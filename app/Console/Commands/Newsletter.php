<?php

namespace App\Console\Commands;

use DB;
use Mail;
use Cache;
use App\User;
use App\Content;
use Carbon\Carbon;
use App\Destination;
use App\NewsletterSent;
use App\NewsletterType;
use App\NewsletterSubscription;
use Illuminate\Console\Command;
use App\NewsletterSentSubscriber;
use App\Mail\Newsletter as NewsletterMail;

class Newsletter extends Command
{
    protected $signature = 'newsletter:send {--import-subscribers} {--check-newsletters}';

    protected $mails_per_hour = 24000;
    protected $mails_per_minute = null;
    protected $first_active_at = '2017-08-17 17:00:00';
    protected $chunk_max = 750;
    protected $destinations = null;
    protected $micro_start = null;
    protected $sub_destinations = [];
    protected $parent_destinations = [];
    protected $cache_time = 10080;

    public function handle()
    {
        $this->micro_start = microtime(true);
        $sleep_time = 0;
        DB::disableQueryLog();

        if ($this->option('import-subscribers')) {
            $newsletter = NewsletterType::where('type', 'weekly')
                ->with('all_subscriptions')
                ->first();

            if ($newsletter) {
                $users = User::select('id')->orderBy('id', 'asc');

                $subscription_ids = [];

                if (count($newsletter->all_subscriptions)) {
                    $subscription_ids = $newsletter->all_subscriptions->keyBy('user_id')->toArray();
                }

                $total_count = 0;
                $users->chunk(750, function ($users_chunk) use ($newsletter, $subscription_ids, &$total_count) {
                    $insert = [];
                    foreach ($users_chunk as &$user) {
                        if (! in_array($user->id, $subscription_ids)) {
                            $total_count++;
                            $insert[] = [
                                'newsletter_type_id' => $newsletter->id,
                                'user_id' => $user->id,
                                'active' => 1,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                        }
                    }

                    if (count($insert)) {
                        NewsletterSubscription::insert($insert);

                        $this->info($total_count.' Kasutajat lisatud uudiskirjaga liitujate alla.');
                    }
                });
            }
        } else {
            $this->mails_per_minute = (int) round($this->mails_per_hour / 60);

            $check_active_at = Carbon::createFromFormat('Y-m-d H:i:s', $this->first_active_at);

            if ($this->option('check-newsletters')) {
                $newsletters = NewsletterType::where('active', 1)->with([
                    'newsletter_visible_content',
                    'subscriptions',
                    //'subscriptions.sents',
                ])->get();

                foreach ($newsletters as &$newsletter) {
                    if ($newsletter->check_user_active_at && $check_active_at->addDays($newsletter->send_days_after)->timestamp <= Carbon::now()->timestamp) {
                        $this->info('Tegelen mitte aktiivsete kasutaja kontrollimise ja vajadusel uudiskirja ootenimekirja lisamisega.');

                        $newsletter->last_sent_at = Carbon::now();
                        $newsletter->save();

                        $this->queueLongTimeAgo($newsletter);
                    } elseif ($newsletter->type == 'flight' && $newsletter->subscriptions->count()) {
                        $this->info('Tegelen lennupakkumiste kontrollimise ja vajadusel uudiskirja ootenimekirja lisamisega.');

                        $newsletter->last_sent_at = Carbon::now();
                        $newsletter->save();

                        $this->getDestinations();

                        $this->queueFlights($newsletter);
                    } elseif ($newsletter->type == 'flight_general' &&
                        (! $newsletter->send_at || ($newsletter->send_at->timestamp <= Carbon::now()->timestamp)) &&
                        $newsletter->subscriptions->count()) {
                        $this->info('Tegelen külalistele lennupakkumiste kontrollimise ja vajadusel ootenimirja lisamisega.');

                        $newsletter->last_sent_at = Carbon::now();
                        $newsletter->send_at = Carbon::now()->addDays($newsletter->send_days_after);
                        $newsletter->save();

                        $this->queueNewsletter($newsletter);
                    } elseif ($newsletter->type == 'weekly' &&
                        (! $newsletter->send_at || ($newsletter->send_at->timestamp <= Carbon::now()->timestamp)) &&
                        $newsletter->subscriptions->count()) {
                        $this->info('Tegelen nädalauudiskirja kontrollimise ja vajadusel uudiskirja ootenimekirja lisamisega.');

                        $newsletter->last_sent_at = Carbon::now();
                        $newsletter->send_at = Carbon::now()->addDays($newsletter->send_days_after);
                        $newsletter->save();

                        $this->queueNewsletter($newsletter);
                    }
                }
            } elseif ($this->time_spent() < 290) {
                $this->line('Alustan kirjade välja saatmisega');

                $mail_receivers = NewsletterSentSubscriber::with([
                    'sent',
                    'user',
                    'subscription',
                    'subscription.user',
                    'sent.newsletter_type',
                ])->where('sending', 1)
                    ->take($this->mails_per_minute)
                    ->orderBy('id', 'asc')
                    ->get();

                // To avoid double mails
                NewsletterSentSubscriber::whereIn('id', $mail_receivers->pluck('id')->toArray())->update([
                    'sending' => 0,
                ]);

                if (! is_array($this->destinations)) {
                    $this->destinations = $this->getDestinations(false);
                }

                $destination_names = Cache::remember('mail_destinations_pluck', $this->cache_time, function () {
                    return $this->destinations->pluck('name', 'id')->toArray();
                });

                $k = 0;
                $total = 0;
                $receivers_total = $mail_receivers->count();
                foreach ($mail_receivers as &$mail_receiver) {
                    $k++;
                    $total++;

                    if ($mail_receiver->sent) {
                        $body = $mail_receiver->sent->composed_content;

                        if ($mail_receiver->sent->destination_id && isset($destination_names[$mail_receiver->sent->destination_id])) {
                            $destination_name = $destination_names[$mail_receiver->sent->destination_id];
                        } else {
                            $destination_name = '';
                        }

                        $email = null;
                        $name = null;
                        $subject = null;
                        $category = null;
                        $user_id = 'guest';
                        $unsubscribe_route = null;
                        if ($mail_receiver->subscription) {
                            if ($mail_receiver->subscription->email) {
                                $email = $mail_receiver->subscription->email;
                            } else {
                                if ($mail_receiver->subscription->user) {
                                    $email = $mail_receiver->subscription->user->email;
                                    $name = $mail_receiver->subscription->user->name;
                                    $user_id = $mail_receiver->subscription->user->id;
                                }
                            }

                            if ($mail_receiver->sent->newsletter_type) {
                                $subject = $mail_receiver->sent->newsletter_type->subject;

                                if (strpos($subject, '[[destination_name]]')) {
                                    $subject = str_replace('[[destination_name]]', $destination_name, $subject);
                                }

                                if ($mail_receiver->sent->newsletter_type->type == 'flight') {
                                    $category = 'Lennupakkumine_'.$destination_name;
                                } else {
                                    $category = $mail_receiver->sent->newsletter_type->type;
                                }
                            }

                            // sha1(subscription.id + subscription.email + subscription.user_id + subscription.created_at)
                            $unsubscribe_route = route('newsletter.unsubscribe', [sha1($mail_receiver->subscription->id.$mail_receiver->subscription->email.$mail_receiver->subscription->user_id.$mail_receiver->subscription->created_at), $mail_receiver->subscription->id]);
                        } elseif ($mail_receiver->user) {
                            $email = $mail_receiver->user->email;
                            $name = $mail_receiver->user->name;
                            $user_id = $mail_receiver->user->id;
                            $subject = $mail_receiver->sent->newsletter_type->subject;
                            $unsubscribe_route = null;
                        }

                        if ($email && $subject && $body/* && $user_id && $unsubscribe_route*/) {
                            Mail::to($email, $name)->send(new NewsletterMail($body, $subject, $category, $user_id, $unsubscribe_route));

                            if ($k == 50 || $receivers_total == $total) {
                                $k = 0;
                                $this->line('Sending.. '.$total.'/'.$receivers_total);
                            }

                            // sleep for 500 ms - don't know if necessary but maybe there is spam risk without that
                            $sleep_seconds = 1;
                            $sleep_time += $sleep_seconds;
                            usleep((int) ($sleep_seconds * 1000000));
                        } else {
                            $this->error('Unable to send. Missing e-mail, subject, body, user_id or unsubscribe_route');
                        }
                    }
                }
            }
        }

        $this->info('Task lõpetatud praeguseks. Aega kulus kokku: '.$this->time_spent().' sekundit (millest uneaega '.(float) $sleep_time.' sekundit).');
    }

    protected function time_spent()
    {
        return round(microtime(true) - $this->micro_start, 4);
    }

    protected function queueNewsletter($newsletter)
    {
        $sent = NewsletterSent::where('newsletter_type_id', $newsletter->id)
            ->whereNull('ended_at')
            ->first();

        if ($sent && $sent->started_at->format('Y-m-d') != Carbon::now()->format('Y-m-d')) {
            $sent->ended_at = Carbon::now();
            $sent->save();

            $sent = null;
        }

        if (! $sent) {
            $body = '';

            foreach ($newsletter->newsletter_visible_content as &$content) {
                $body .= $content->vars()->compose(null, $newsletter);
            }

            $sent = $this->createNewSent([
                'newsletter_type_id' => $newsletter->id,
                'started_at' => Carbon::now(),
                'composed_content' => $body,
            ]);
        }

        $count_added = 0;
        $chunk_count = 0;
        $chunk_rounds = 0;
        $chunk_max = $this->chunk_max;
        $insert_to_queue = [];
        $subscriptions_count = $newsletter->subscriptions->count();

        foreach ($newsletter->subscriptions as &$subscription) {
            $chunk_count++;
            $count_added++;
            $insert_to_queue[] = [
                'subscription_id' => $subscription->id,
                'sent_id' => $sent->id,
                'user_id' => $sent->user_id,
                'sending' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            if ($chunk_count == $chunk_max || $count_added == $subscriptions_count) {
                $chunk_rounds++;
                $chunk_count = 0;

                NewsletterSentSubscriber::insert($insert_to_queue);

                if ($count_added == $subscriptions_count || $chunk_rounds == 10) {
                    $chunk_rounds = 0;
                    $this->line($count_added.' liitujat lisatud kirja saajate ootelisti.');
                }

                $insert_to_queue = [];
            }
        }
    }

    protected function queueLongTimeAgo($newsletter)
    {
        $users = User::select('id')
            ->where(function ($query) use ($newsletter) {
                $query->whereNull('active_at')
                    ->orWhere('active_at', '<=', DB::raw('(NOW() - INTERVAL '.$newsletter->send_days_after.' DAY)'));
            })->whereRaw('(SELECT COUNT(*) FROM `newsletter_sent_subscribers` WHERE `user_id` = `users`.`id` AND (`newsletter_sent_subscribers`.`created_at` > (NOW() - INTERVAL '.$newsletter->send_days_after.' DAY))) = 0')
            ->orderBy('id', 'asc');

        $users_count = $users->count();

        if ($users_count) {
            $sent = NewsletterSent::where('newsletter_type_id', $newsletter->id)
                ->whereNull('ended_at')
                ->first();

            if ($sent && $sent->started_at->format('Y-m-d') != Carbon::now()->format('Y-m-d')) {
                $sent->ended_at = Carbon::now();
                $sent->save();

                $sent = null;
            }

            if (! $sent) {
                $body = '';

                foreach ($newsletter->newsletter_visible_content as &$content) {
                    $body .= $content->vars()->compose(null, $newsletter);
                }

                $sent = $this->createNewSent([
                    'newsletter_type_id' => $newsletter->id,
                    'started_at' => Carbon::now(),
                    'composed_content' => $body,
                ]);
            }

            $this->info($users_count.' kasutajat pole sisse loginud vähemalt '.$newsletter->send_days_after.' päeva');
            $count_added = 0;

            $chunk_count = 0;
            $chunk_rounds = 0;
            $chunk_max = $this->chunk_max;
            $insert_to_queue = [];
            foreach ($users->get() as &$user) {
                $chunk_count++;
                $count_added++;
                $insert_to_queue[] = [
                    'subscription_id' => null,
                    'sent_id' => $sent->id,
                    'user_id' => $user->id,
                    'sending' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                if ($chunk_count == $chunk_max || $count_added == $users_count) {
                    $chunk_rounds++;
                    $chunk_count = 0;

                    NewsletterSentSubscriber::insert($insert_to_queue);

                    if ($count_added == $users_count || $chunk_rounds == 10) {
                        $chunk_rounds = 0;
                        $this->line($count_added.' kasutajat lisatud "Pole ammu sind näinud" kirja saajate ootelisti.');
                    }

                    $insert_to_queue = [];
                }
            }
        }
    }

    protected function queueFlights($newsletter)
    {
        $destination_ids = $newsletter->subscriptions->pluck('destination_id')->unique()->reject(function ($value, $key) {
            return ! $value;
        })->toArray();
        $price_error = $newsletter->subscriptions->pluck('price_error')->unique()->reject(function ($value, $key) {
            return ! $value;
        })->toArray();

        $destination_ids_total = count($destination_ids);
        $count_processed = 0;
        $chunk_count = 0;
        $chunk_max = $this->chunk_max;
        $flights = collect();

        $find_by_destinations = [];
        foreach ($destination_ids as &$destination_id) {
            $chunk_count++;
            $count_processed++;

            $find_by_destinations[] = $destination_id;

            if (isset($this->sub_destinations[$destination_id])) {
                $find_by_destinations = array_merge($find_by_destinations, $this->sub_destinations[$destination_id]);
            }

            if ($chunk_count == $chunk_max || $count_processed == $destination_ids_total) {
                $chunk_count = 0;

                $content = Content::where('status', 1)
                    ->join('content_destination', 'content_destination.content_id', '=', 'contents.id')
                    ->select([
                        'contents.*',
                        'content_destination.destination_id',
                    ])->where('type', 'flight')
                    ->whereDate('created_at', Carbon::today()->format('Y-m-d'));

                if (count($price_error)) {
                    $content = $content->where(function ($query) use ($find_by_destinations) {
                        $query->whereIn('content_destination.destination_id', $find_by_destinations)
                            ->orWhereRaw('LOWER(`title`) LIKE \'%'.mb_strtolower('veahind').'%\'');
                    });
                } else {
                    $content = $content->whereIn('content_destination.destination_id', $find_by_destinations);
                }

                $flights = $flights->merge($content->get());

                $find_by_destinations = [];
            }
        }

        $flights_total = count($flights);
        if ($flights_total) {
            $previous_sents = NewsletterSent::where('newsletter_type_id', $newsletter->id)
                ->where(function ($query) use ($price_error, $destination_ids) {
                    if (count($price_error)) {
                        $query->whereIn('destination_id', $destination_ids)
                            ->orWhere('price_error', 1);
                    } else {
                        $query->whereIn('destination_id', $destination_ids);
                    }
                })
                ->whereNull('ended_at')
                ->get();

            $sents = collect([]);

            $update_sents = [];
            foreach ($previous_sents as &$sent) {
                if ($sent->started_at->format('Y-m-d') != Carbon::now()->format('Y-m-d')) {
                    $update_sents[] = $sent->id;
                } else {
                    $sents = $sents->merge([$sent]);
                }
            }
            $sent_content_ids = $sents->pluck('content_id')->toArray();

            if (count($update_sents)) {
                NewsletterSent::whereIn('id', $update_sents)->update([
                    'ended_at' => Carbon::now(),
                ]);
            }

            $flight_contents = [];
            $flight_ids = [];

            $count_processed = 0;
            $chunk_count = 0;
            $chunk_max = $this->chunk_max;
            $possible_destinations = [];
            foreach ($flights as &$flight) {
                $possible_destinations[] = $flight->destination_id;
                if (isset($this->parent_destinations[$flight->destination_id])) {
                    $possible_destinations = array_merge($possible_destinations, $this->parent_destinations[$flight->destination_id]);
                }

                foreach ($newsletter->subscriptions as &$subscription) {
                    if (in_array($subscription->destination_id, $possible_destinations)) {
                        $flight->destination_id = $subscription->destination_id;

                        break;
                    }
                }

                $chunk_count++;
                $count_processed++;
                if (! in_array($flight->id, $flight_ids)) {
                    $flight_ids[] = $flight->id;
                }

                if (! in_array($flight->id, $sent_content_ids)) {
                    $flight_body = '';

                    foreach ($newsletter->newsletter_visible_content as &$content) {
                        $flight_body .= $content->vars()->compose($flight, $newsletter);
                    }

                    $flight_contents[] = [
                        'newsletter_type_id' => $newsletter->id,
                        'composed_content' => $flight_body,
                        'destination_id' => $flight->destination_id,
                        'price_error' => strpos(mb_strtolower($flight->title), 'veahind') !== false ? 1 : 0,
                        'content_id' => $flight->id,
                        'started_at' => Carbon::now(),
                        'ended_at' => null,
                    ];
                }

                if ($chunk_count == $chunk_max || $count_processed == $flights_total) {
                    $chunk_count = 0;

                    NewsletterSent::insert($flight_contents);

                    $flight_contents = [];
                }
            }

            $sents = NewsletterSent::select(['id', 'price_error', 'content_id', 'destination_id'])
                ->where(function ($query) use ($price_error, $destination_ids) {
                    if (count($price_error)) {
                        $query->whereIn('destination_id', $destination_ids)
                            ->orWhere('price_error', 1);
                    } else {
                        $query->whereIn('destination_id', $destination_ids);
                    }
                })
                ->whereIn('content_id', $flight_ids)
                ->where('newsletter_type_id', $newsletter->id)
                ->whereNull('ended_at')
                ->get();

            $count_processed = 0;
            $chunk_count = 0;
            $chunk_max = $this->chunk_max;

            $total_subscriptions = $newsletter->subscriptions->count();
            $insert = [];

            foreach ($newsletter->subscriptions as &$subscription) {
                $chunk_count++;
                $count_processed++;

                foreach ($sents as &$sent) {
                    if ($sent->destination_id == $subscription->destination_id || ($sent->price_error == 1 && $subscription->price_error == 1)) {
                        $existing_sent_ids = [];
                        if ($subscription->sents->count()) {
                            $existing_sent_ids = $subscription->sents->pluck('sent_id')->toArray();
                        }

                        if (! in_array($sent->id, $existing_sent_ids)) {
                            $insert[] = [
                                'subscription_id' => $subscription->id,
                                'sent_id' => $sent->id,
                                'user_id' => $subscription->user_id,
                                'sending' => 1,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                        }
                    }
                }

                if ($chunk_count == $chunk_max || $count_processed == $total_subscriptions) {
                    $chunk_count = 0;

                    if (count($insert)) {
                        NewsletterSentSubscriber::insert($insert);
                    }

                    $insert = [];
                }
            }
        }
    }

    protected function createNewSent($data = [])
    {
        if (count($data)) {
            $sent = new NewsletterSent;

            foreach ($data as $key => &$value) {
                $sent->$key = $value;
            }

            $sent->save();

            return $sent;
        } else {
            throw new \Exception('Please provide data for NewsletterSent model.');
        }
    }

    protected function getDestinations($check_subs = true)
    {
        $this->destinations = Cache::remember('mail_destinations', $this->cache_time, function () {
            $destinations = Destination::select(['id', 'name', 'parent_id'])->get();

            return $destinations;
        });

        if ($check_subs) {
            $this->sub_destinations = Cache::remember('newsletter_sub_destinations', $this->cache_time, function () {
                $subs = [];

                foreach ($this->destinations as &$destination) {
                    $subs[$destination->id] = $this->getChild($destination->id, $this->destinations);
                }

                return $subs;
            });

            $this->parent_destinations = Cache::remember('newsletter_parent_destinations', $this->cache_time, function () {
                $parents = [];

                $destinations_by_id = $this->destinations->keyBy('id');

                foreach ($this->destinations as &$destination) {
                    $parents[$destination->id] = $this->getParents($destination->id, $destinations_by_id);
                }

                return $parents;
            });
        }

        return $this->destinations;
    }

    protected function getParents($id, $data = [], $parents = [])
    {
        $parent_id = isset($data[$id]) ? $data[$id]->parent_id : 0;

        if ($parent_id > 0) {
            array_unshift($parents, $parent_id);

            return $this->getParents($parent_id, $data, $parents);
        }

        return $parents;
    }

    protected function getChild($id, $data = [], $child = [])
    {
        foreach ($data as &$item) {
            if ($item->parent_id == $id) {
                array_unshift($child, $item->id);

                $child = $this->getChild($item->id, $data, $child);
            }
        }

        return $child;
    }
}
