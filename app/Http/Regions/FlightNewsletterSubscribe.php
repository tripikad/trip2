<?php

namespace App\Http\Regions;

use Cache;
use App\Destination;
use App\NewsletterType;

class FlightNewsletterSubscribe
{
  public static $max = 5;

  public function render()
  {
    $selected_values = [];
    $request = request();
    $user = $request->user();

    $newsletter_type = NewsLetterType::whereType($user ? 'flight' : 'flight_general')->whereActive(1);

    if ($user) {
      $newsletter_type = $newsletter_type->with('user_subscriptions');
    }

    $newsletter_type = $newsletter_type->first();

    if ($newsletter_type) {
      if ($user) {
        $subscriptions = $newsletter_type->user_subscriptions;

        if ($subscriptions) {
          $subscriptions = $subscriptions->where('active', 1);
        }
      } else {
        $subscriptions = collect([]);
      }

      /*$destinations = Cache::remember('continents_and_countries', 30, function () {
                      return Destination::select('id', 'name')->get();
                  });*/

      $destinations = Cache::remember('continents_and_countries', 30, function () {
        $destinations = Destination::select(['id', 'name', 'parent_id'])
          ->where('depth', '<=', 1)
          ->get();

        /*$parent_destinations = [];
                        foreach ($destinations as &$destination) {
                            if (! $destination->parent_id) {
                                $parent_destinations[$destination->id] = $destination->name;
                            }
                        }

                        foreach ($destinations as &$destination) {
                            if ($destination->parent_id && isset($parent_destinations[$destination->parent_id])) {
                                $destination->name = $parent_destinations[$destination->parent_id] . ' › ' . $destination->name;
                            }
                        }*/

        return $destinations;
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
          $selected_values = array_values(
            $subscriptions
              ->pluck('destination_id')
              ->reject(function ($value, $key) {
                return !$value;
              })
              ->toArray()
          );
          $price_error = $subscriptions->where('price_error', 1)->first();
        }

        $fields
          ->push(
            component('FormSelectMultiple')
              ->with('name', 'destinations')
              ->with('options', $destinations)
              ->with('value', $selected_values)
              ->with('placeholder', trans('newsletter.subscribe.field.destinations', ['max' => self::$max]))
              ->with('max', self::$max)
              ->with('max_limit_text', trans('error.max_limit'))
              ->with('close_on_select', false)
          )
          ->push(
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

      return component('Block')
        ->is('gray')
        ->with('title', trans('newsletter.subscribe.flight.heading'))
        ->with(
          'content',
          collect()
            ->push(
              component('Form')
                ->with('route', route('newsletter.subscribe', [$newsletter_type]))
                ->with('id', 'FlightNewsletterSubscribeForm')
                ->with('fields', $fields)
            )
            ->pushWhen(
              $info,
              component('Body')
                ->is('small')
                ->with('body', $info)
            )
        );
    } else {
      return;
    }
  }
}
