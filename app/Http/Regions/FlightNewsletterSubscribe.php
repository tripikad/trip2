<?php

namespace App\Http\Regions;

use Cache;
use App\Destination;
use App\NewsletterType;

class FlightNewsletterSubscribe
{
    public $max = 5;

    public function render()
    {
        $selected_values = [];
        $request = request();
        $user = $request->user();

        $newsletter_type = NewsLetterType::whereType(($user ? 'flight' : 'flight_general'))->whereActive(1);

        if ($user) {
            $newsletter_type = $newsletter_type->with('user_subscriptions');
        }

        $newsletter_type = $newsletter_type->first();

        if ($newsletter_type) {
            if ($user) {
                $subscriptions = $newsletter_type->user_subscriptions;
            } else {
                $subscriptions = collect([]);
            }

            $destinations = Cache::remember('destinations', 30, function () {
                return Destination::select('id', 'name')->get();
            });

            if ($request->old('destinations')) {
                $selected_values = [];

                foreach ($request->old('destinations') as $destination) {
                    $selected_values[] = (int) $destination;
                }

                $selected_values = collect($selected_values);
            }

            $fields = collect();
            $info = null;
            if ($user) {
                //dd($subscriptions);
                if (count($subscriptions)) {
                    $selected_values = array_values($subscriptions->pluck('destination_id')->reject(function ($value, $key) {
                        return ! $value;
                    })->toArray());
                    $price_error = $subscriptions->where('price_error', 1)->first();
                }

                $fields->push(
                    component('FormSelectMultiple')
                        ->with('name', 'destinations')
                        ->with('options', $destinations)
                        ->with('value', $selected_values)
                        ->with('placeholder', trans('newsletter.subscribe.field.destinations', ['max' => $this->max]))
                        ->with('max', $this->max)
                        ->with('max_limit_text', trans('error.max_limit'))
                        ->with('close_on_select', false)
                )->push(
                    component('FormCheckbox')
                        ->with('title', trans('newsletter.subscribe.field.price_error'))
                        ->with('name', 'price_error')
                        ->with('value', $price_error ?? 0)
                );
            } else {
                $fields->push(
                    component('FormTextfield')
                        ->with('name', 'e-post')
                        ->with('placeholder', trans('newsletter.subscribe.field.email'))
                );

                $info = trans('newsletter.subscribe.info.general');
            }

            $fields->push(
                component('FormButtonProcess')
                    ->with('title', trans('newsletter.button.subscribe_flight'))
                    ->with('processingtitle', trans('newsletter.button.subscribe_processing'))
                    ->with('id', 'FlightNewsletterSubscribeForm')
            );

            return component('FlightNewsletterSubscribe')
                ->with('info', $info)
                ->with('form', component('Form')
                    ->with('route', route('newsletter.subscribe', [$newsletter_type]))
                    ->with('id', 'FlightNewsletterSubscribeForm')
                    ->with('fields', $fields)
                );
        } else {
            return null;
        }
    }
}
