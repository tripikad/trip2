<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\NewsletterType;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use App\NewsletterSubscription;
use App\Http\Regions\FlightNewsletterSubscribe;

class V2NewsletterController extends Controller
{
    public function index()
    {
        $newsletter_types = NewsletterType::all();

        $navBar = collect();

        foreach ($newsletter_types as &$newsletter_type) {
            if (strpos($newsletter_type->subject, '%destination_name') !== false) {
                $newsletter_type->subject = str_replace('%destination_name', '...', $newsletter_type->subject);
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
        if (strpos($newsletter->subject, '%destination_name') !== false) {
            $newsletter->subject = str_replace('%destination_name', '...', $newsletter->subject);
        }

        $newsletter_types = NewsletterType::all();
        $navBar = collect();

        foreach ($newsletter_types as &$newsletter_type) {
            if (strpos($newsletter_type->subject, '%destination_name') !== false) {
                $newsletter_type->subject = str_replace('%destination_name', '...', $newsletter_type->subject);
            }

            $navBar->push(component('Button')
                ->with('title', $newsletter_type->subject)
                ->with('route', route('newsletter.view', [$newsletter_type]))
            );
        }

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
            ->with('content', 'To-do: Uudiskirjade nimekiri koos infoga tuleb siia')
            ->with('sidebar', $navBar)
            ->with('footer', region('FooterLight'))
            ->render();
    }

    public function edit($id)
    {
    }

    public function store(Request $request, $id)
    {
    }

    public function subscribe(Request $request, $id)
    {
        $newsletter_type = NewsLetterType::findOrFail($id);

        $user = $request->user();
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
        }

        if (isset($errors) && count($errors)) {
            return redirect()->back()->withErrors($errors);
        } elseif (isset($info) && $info) {
            return redirect()->back()->with('info', $info);
        }
    }

    public function preview($id)
    {
        $markdown = new Markdown(view(), config('mail.markdown'));

        return $markdown->render('email.newsletter.long_time_ago', [
            'unsubscribe_id' => 4,
        ]);
    }
}
