<?php

namespace App\Http\Controllers;

use App\User;
use App\Content;
use Carbon\Carbon;
use App\NewsletterSent;
use App\NewsletterType;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use App\NewsletterSubscription;
use App\NewsletterLetterContent;
use App\Http\Regions\FlightNewsletterSubscribe;

class V2NewsletterController extends Controller
{
    public function index()
    {
        $newsletter_types = NewsletterType::all();

        $navBar = collect();

        foreach ($newsletter_types as &$newsletter_type) {
            if (strpos($newsletter_type->subject, '[[destination_name]]') !== false) {
                $newsletter_type->subject = str_replace('[[destination_name]]', '...', $newsletter_type->subject);
            }

            $navBar->push(component('Button')
                ->with('title', $newsletter_type->subject)
                ->with('route', route('newsletter.view', [$newsletter_type]))
            );
        }

        return layout('1col')
            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')
            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->with('title', trans('menu.admin.newsletter'))
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
            ))
            ->with('content', $navBar)
            ->with('footer', region('FooterLight'))
            ->render();
    }

    public function view($id)
    {
        $newsletter = NewsLetterType::findOrFail($id);
        if (strpos($newsletter->subject, '[[destination_name]]') !== false) {
            $newsletter->subject = str_replace('[[destination_name]]', '...', $newsletter->subject);
        }

        $newsletter_types = NewsletterType::all();
        $navBar = collect();

        foreach ($newsletter_types as &$newsletter_type) {
            if (strpos($newsletter_type->subject, '[[destination_name]]') !== false) {
                $newsletter_type->subject = str_replace('[[destination_name]]', '...', $newsletter_type->subject);
            }

            $navBar->push(component('Link')
                ->with('icon', false)
                ->with('title', $newsletter_type->subject)
                ->with('route', route('newsletter.view', [$newsletter_type]))
            );
        }

        $sents = NewsletterSent::where('newsletter_type_id', $id)
            ->with([
                'newsletter_type',
                'destination',
                'subscriptions',
                'sent',
            ])
            ->orderBy('id', 'asc')
            ->paginate(15);

        $left_content = collect();
        $right_content = collect();
        $sents->each(function ($sent) use (&$left_content, &$right_content) {
            $subject = $sent->newsletter_type->subject;
            $subject = str_replace('[[destination_name]]', ($sent->destination ? $sent->destination->name : ''), $subject);
            $left_content->push(component('Meta')
                ->with('items', collect()
                    ->push(
                        component('Body')
                            ->with('body', $subject)
                    )
                    ->push(
                        component('Tag')
                            ->with('title', trans('newsletter.started_at').' '.format_date($sent->started_at))
                    )
                    ->push(
                        component('Tag')
                            ->with('title', trans('newsletter.ended_at').' '.($sent->ended_at ? format_date($sent->started_at) : trans('newsletter.tag.future')))
                    )
                    ->push(
                        component('Tag')
                            ->with('title', trans('newsletter.sent').' '.$sent->sent->where('sending', 0)->count().' / '.$sent->sent->count())
                    )
                )
            );

            $right_content->push(
                component('Button')
                    ->with('external', true)
                    ->with('title', trans('newsletter.button.view.sent'))
                    ->with('route', route('newsletter.preview_sent', [$sent]))
            );
        });

        return layout('2col')
            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')
            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->with('title', trans('newsletter.title').': '.$newsletter->subject)
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
            ))
            ->with('content', collect()
                ->push(component('Grid2')
                    ->with('gutter', true)
                    ->with('items', [
                        component('Button')
                            ->with('title', trans('newsletter.button.edit'))
                            ->with('route', route('newsletter.edit', [$newsletter])),
                        component('Button')
                            ->is('cyan')
                            ->with('external', true)
                            ->with('title', trans('newsletter.button.preview'))
                            ->with('route', route('newsletter.preview', [$newsletter])),
                    ])
                )
                ->push(component('GridSplit')
                    ->with('left_col', 9)
                    ->with('right_col', 3)
                    ->with('left_content', $left_content)
                    ->with('right_content', $right_content)
                )
                ->push(region('Paginator', $sents))
            )
            ->with('sidebar', $navBar)
            ->with('footer', region('FooterLight'))
            ->render();
    }

    public function edit($id)
    {
        $request = request();
        $newsletter = NewsLetterType::findOrFail($id);
        if (strpos($newsletter->subject, '[[destination_name]]') !== false) {
            $newsletter->subject = str_replace('[[destination_name]]', '...', $newsletter->subject);
        }

        $letter_contents = [];
        if ($request->old('body')) {
            foreach ($request->old('body') as $key => &$body) {
                $letter_contents[$key] = [
                    'body' => $body,
                    'visible_from' => $request->old('visible_from')[$key],
                    'visible_to' => $request->old('visible_to')[$key],
                ];
            }
        } else {
            $letter_contents = NewsletterLetterContent::select('body', 'visible_from', 'visible_to')->where('newsletter_type_id', $newsletter->id)
                ->orderBy('sort_order', 'asc')
                ->get()
                ->toArray();

            foreach ($letter_contents as &$letter_content) {
                if ($letter_content['visible_from']) {
                    $letter_content['visible_from'] = Carbon::createFromFormat('Y-m-d', $letter_content['visible_from'])->format('d.m.Y');
                }

                if ($letter_content['visible_to']) {
                    $letter_content['visible_to'] = Carbon::createFromFormat('Y-m-d', $letter_content['visible_to'])->format('d.m.Y');
                }
            }
        }

        return layout('1col')
            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')
            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->with('title', trans('newsletter.title').': '.$newsletter->subject)
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
            ))
            ->with('column_class', 'col-11')
            ->with('content', collect()
                ->push(
                    component('Form')
                        ->with('route', route('newsletter.store', [$newsletter]))
                        ->with('id', 'FlightNewsletterSubscribeForm')
                        ->with('fields', collect()->push(
                            component('NewsletterComposer')
                                ->with('content_placeholder', trans('newsletter.field.content'))
                                ->with('visible_from_placeholder', trans('newsletter.field.visible_from'))
                                ->with('visible_to_placeholder', trans('newsletter.field.visible_to'))
                                ->with('cheatsheet', trans('newsletter.cheatsheet.content'))
                                ->with('letter_contents', $letter_contents)
                        )->push(
                            component('FormButtonProcess')
                                ->with('title', trans('newsletter.button.edit'))
                                ->with('processingtitle', trans('newsletter.button.subscribe_processing'))
                                ->with('id', 'FlightNewsletterSubscribeForm')
                        ))
                )
            )
            ->with('footer', region('FooterLight'))
            ->render();
    }

    public function store(Request $request, $id)
    {
        $newsletter = NewsLetterType::findOrFail($id);
        $insert = [];
        $errors = [];
        if ($request->input('body') == null) {
            $errors[] = trans('newsletter.error.empty');
        } else {
            $sort_order = 0;
            foreach ($request->input('body') as $key => &$body) {
                ++$sort_order;

                $date_from = $request->input('visible_from')[$key] == '' ? null : $request->input('visible_from')[$key];
                $date_to = $request->input('visible_to')[$key] == '' ? null : $request->input('visible_to')[$key];

                foreach (['date_from', 'date_to'] as $date) {
                    if ($$date) {
                        $date_from_arr = explode('.', $$date);

                        if (count($date_from_arr) == 3) {
                            if (! checkdate($date_from_arr[1], $date_from_arr[0], $date_from_arr[2])) {
                                $errors[] = trans('newsletter.error.wrong_date_format', ['date' => $$date]);
                            } else {
                                $$date = Carbon::createFromDate($date_from_arr[2], $date_from_arr[1], $date_from_arr[0])->format('Y-m-d');
                            }
                        } else {
                            $errors[] = trans('newsletter.error.wrong_date_format', ['date' => $$date]);
                        }
                    }
                }

                $insert[] = [
                    'newsletter_type_id' => $newsletter->id,
                    'body' => $body,
                    'visible_from' => $date_from,
                    'visible_to' => $date_to,
                    'sort_order' => $sort_order,
                ];
            }
        }

        if (count($errors)) {
            return redirect()->back()->withInput($request->input())->withErrors($errors);
        } else {
            NewsletterLetterContent::where('newsletter_type_id', $newsletter->id)
                ->delete();

            NewsletterLetterContent::insert($insert);

            return redirect()
                ->route('newsletter.view', [$newsletter])
                ->with('info', trans('newsletter.content.modified.successfully'));
        }
    }

    public function subscribe(Request $request, $id, $user = null, $skip_request = false)
    {
        $newsletter_type = NewsLetterType::findOrFail($id);

        if ($user === null) {
            $user = $request->user();
        }

        $errors = [];

        if ($newsletter_type->type == 'flight' && $user) {
            $previous_subscriptions = NewsletterSubscription::where('user_id', $user->id)
                ->where('newsletter_type_id', $id)
                ->get();

            $deactivate_subscription_ids = [];
            $activate_subscription_ids = [];

            $destination_ids = $request->input('destinations') ?? [];
            $price_error = $request->input('price_error') ? 1 : 0;

            if (count($destination_ids) > FlightNewsletterSubscribe::$max) {
                $errors[] = trans('newsletter.max_limit_exceeded', ['max' => FlightNewsletterSubscribe::$max]);
            }

            if (! count($errors)) {
                $insert_destinations = $destination_ids;
                $insert_price_error = $price_error;

                foreach ($previous_subscriptions as &$previous_subscription) {
                    if ($previous_subscription->price_error) {
                        $insert_price_error = 0;
                    } elseif ($previous_subscription->destination_id && in_array($previous_subscription->destination_id, $insert_destinations)) {
                        unset($insert_destinations[array_search($previous_subscription->destination_id, $insert_destinations)]);
                    }

                    if ($previous_subscription->active) {
                        if ($previous_subscription->destination_id && ! in_array($previous_subscription->destination_id, $destination_ids)) {
                            $deactivate_subscription_ids[] = $previous_subscription->id;
                        } elseif ($previous_subscription->price_error && ! $price_error) {
                            $deactivate_subscription_ids[] = $previous_subscription->id;
                        }
                    } else {
                        if ($previous_subscription->destination_id && in_array($previous_subscription->destination_id, $destination_ids)) {
                            $activate_subscription_ids[] = $previous_subscription->id;
                        } elseif ($previous_subscription->price_error && $price_error) {
                            $activate_subscription_ids[] = $previous_subscription->id;
                        }
                    }
                }

                // Deactivate
                if (count($deactivate_subscription_ids)) {
                    NewsletterSubscription::whereIn('id', $deactivate_subscription_ids)->update([
                        'active' => 0,
                    ]);
                }

                // Activate
                if (count($activate_subscription_ids)) {
                    NewsletterSubscription::whereIn('id', $activate_subscription_ids)->update([
                        'active' => 1,
                    ]);
                }

                // Insert new record
                $insert_records = [];
                if (count($insert_destinations)) {
                    foreach ($insert_destinations as &$destination_id) {
                        $insert_records[] = [
                            'newsletter_type_id' => $id,
                            'user_id' => $user->id,
                            'price_error' => 0,
                            'destination_id' => $destination_id,
                            'active' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }

                if ($insert_price_error) {
                    $insert_records[] = [
                        'newsletter_type_id' => $id,
                        'user_id' => $user->id,
                        'price_error' => 1,
                        'destination_id' => null,
                        'active' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }

                if (count($insert_records)) {
                    NewsletterSubscription::insert($insert_records);
                }

                $info = trans('newsletter.subscribed.flight.detailed.successfully');
            }
        } elseif ($newsletter_type->type == 'flight_general' && ! $user) {
            $this->validate($request, [
                'e-post' => 'required|email',
            ]);

            $subscription = NewsletterSubscription::where('email', $request->input('e-post'))
                ->where('newsletter_type_id', $id)
                ->whereNull('user_id')
                ->whereNull('destination_id')
                ->first();

            if ($subscription && $subscription->active) {
                $errors[] = trans('newsletter.error.already_subscribed');
            }

            if (! count($errors)) {
                if (! $subscription) {
                    $subscription = new NewsletterSubscription;
                }

                $subscription->newsletter_type_id = (int) $id;
                $subscription->email = $request->input('e-post');
                $subscription->active = 1;
                $subscription->save();
            }

            $info = trans('newsletter.subscribed.flight.successfully');
        } elseif ($newsletter_type->type == 'weekly' && $user) {
            $subscription = NewsletterSubscription::where('user_id', $user->id)
                ->where('newsletter_type_id', $id)
                ->first();

            $newsletter_subscribe = ($skip_request ? 1 : $request->newsletter_subscribe ? 1 : 0);

            if ($subscription) {
                $subscription->active = $newsletter_subscribe;
            } else {
                $subscription = new NewsletterSubscription;
                $subscription->user_id = $user->id;
                $subscription->newsletter_type_id = $id;
                $subscription->active = $newsletter_subscribe;
            }

            $subscription->save();
        }

        if (isset($errors) && count($errors)) {
            return redirect()->back()->withErrors($errors);
        } elseif (isset($info) && $info) {
            return redirect()->back()->with('info', $info);
        }
    }

    public function unsubscribe($hash, $id)
    {
        $subscription = NewsletterSubscription::where('active', 1)->findOrFail($id);

        if (sha1($subscription->id.$subscription->email.$subscription->user_id.$subscription->created_at) == $hash) {
            $title = trans('newsletter.unsubscribed.successfully.title');
            $body = trans('newsletter.unsubscribed.successfully.body');

            $subscription->active = 0;
            $subscription->save();

            return layout('1col')
                ->with('header', region('StaticHeader', collect()
                    ->push(component('Title')
                        ->is('red')
                        ->is('large')
                        ->with('title', $title)
                    )
                ))
                ->with('content', collect()
                    ->push(component('Body')
                        ->is('responsive')
                        ->with('body', $body)
                    )
                    ->push('&nbsp;')
                )
                ->with('footer', region('FooterLight'))
                ->render();
        } else {
            return abort(404);
        }
    }

    public function preview($id)
    {
        $markdown = new Markdown(view(), config('mail.markdown'));

        $newsletter = NewsletterType::findOrFail($id);
        $contents = NewsletterLetterContent::where('newsletter_type_id', $id)->orderBy('sort_order', 'asc')->get();

        $body = '';

        $the_flight = null;
        if ($newsletter->type == 'flight') {
            $the_flight = Content::where('type', 'flight')->with(['destinations', 'images'])
                ->has('destinations')
                ->has('images')
                ->take(1)
                ->inRandomOrder()
                ->first();

            $destination_names = $the_flight->destinations->pluck('name')->first();
            $newsletter->subject = str_replace('[[destination_name]]', $destination_names, $newsletter->subject);
        }

        foreach ($contents as &$content) {
            $body .= $content->vars()->compose($the_flight);
        }

        return $markdown->render('email.newsletter.newsletter', [
            'heading' => $newsletter->subject,
            'body' => $body,
            'unsubscribe_route' => '#',
        ]);
    }

    public function preview_sent($id)
    {
        $markdown = new Markdown(view(), config('mail.markdown'));

        $newsletter = NewsletterSent::with([
            'newsletter_type',
            'destination',
        ])->findOrFail($id);

        return $markdown->render('email.newsletter.newsletter', [
            'heading' => str_replace('[[destination_name]]', ($newsletter->destination ? $newsletter->destination->name : ''), $newsletter->newsletter_type->subject),
            'body' => $newsletter->composed_content,
            'unsubscribe_route' => '#',
        ]);
    }
}
