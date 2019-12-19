<?php

namespace App\Http\Controllers;

use Jenssegers\Date\Date;

use App\Content;
use App\Offer;
use App\Destination;
use App\User;

use Log;

class OfferAdminController extends Controller
{
  public function create($style)
  {
    $isPackage = $style == 'package';

    $destinations = Destination::select('id', 'name')
      ->orderBy('name', 'asc')
      ->get();

    $startDestination = Destination::whereName('Tallinn')->first();

    $hasHotelError = collect(errorKeys() ?? [])
      ->filter(function ($key) {
        return starts_with($key, 'hotel_');
      })
      ->isNotEmpty();

    return layout('Two')
      ->with('color', 'blue')
      ->with(
        'header',
        region(
          'OfferHeader',
          collect()->push(
            component('Title')
              ->is('white')
              ->is('large')
              ->is('center')
              ->withTitle(trans("offer.admin.create.style.$style"))
          )
        )
      )
      ->with(
        'content',
        collect()->push(
          component('Form')
            ->with('route', route('offer.admin.store'))
            ->with(
              'fields',
              collect()
                ->push(
                  component('FormHidden')
                    ->withName('style')
                    ->withValue($style)
                )
                ->push(
                  component('FormCheckbox')
                    ->withName('status')
                    ->withTitle(trans('offer.admin.edit.status'))
                    ->withValue(old('status', true))
                )
                ->push(
                  component('FlexGrid')
                    ->withGap($isPackage ? 0 : 1)
                    ->withWidths($isPackage ? '1fr 0' : '2fr 1fr')
                    ->withItems(
                      collect()
                        ->push(
                          component('FormTextfield')
                            ->withTitle(trans('offer.admin.edit.title'))
                            ->withDescription(trans('site.required'))
                            ->withName('title')
                            ->withValue(old('title'))
                        )
                        ->push(
                          component($isPackage ? 'FormHidden' : 'FormTextfield')
                            ->withTitle(trans('offer.admin.edit.price'))
                            ->withSuffix(config('site.currency.eur'))
                            ->withDescription($isPackage ? '' : trans('site.required'))
                            ->withName('price')
                            ->withValue(old('price'))
                        )
                    )
                )
                ->push(
                  component('FormSelectMultiple')
                    ->with('height', 7)
                    ->withTitle(trans('offer.admin.edit.start_destinations'))
                    ->withDescription(trans('site.required'))
                    ->withName('start_destinations[]')
                    ->with('options', $destinations)
                    ->with('max', 1)
                    ->withValue(old('start_destinations[]', $startDestination ? [$startDestination->id] : []))
                )
                ->push(
                  component('FormSelectMultiple')
                    ->with('height', 7)
                    ->withTitle(trans('offer.admin.edit.end_destinations'))
                    ->withDescription(trans('site.required'))
                    ->withName('end_destinations[]')
                    ->with('options', $destinations)
                    ->withValue(old('end_destinations[]'))
                )
                ->push(
                  component('FlexGrid')
                    ->withGap(1)
                    ->withItems(
                      collect()
                        ->push(
                          component('FormTextfield')
                            ->withTitle(trans('offer.admin.edit.start_at'))
                            ->withDescription(trans('site.required'))
                            ->with('placeholder', Date::now()->format(config('offer.date.inputformat')))
                            ->withName('start_at')
                            ->withValue(old('start_at'))
                        )
                        ->push(
                          component('FormTextfield')
                            ->withTitle(trans('offer.admin.edit.end_at'))
                            ->withDescription(trans('site.required'))
                            ->with('placeholder', Date::now()->format(config('offer.date.inputformat')))
                            ->withName('end_at')
                            ->withValue(old('end_at'))
                        )
                    )
                )
                ->push(
                  component('FormTextfield')
                    ->withDescription(!$isPackage ? trans('site.required') : '')
                    ->withTitle(trans('offer.admin.edit.url'))
                    ->withName('url')
                    ->withPlaceholder('http://')
                    ->withValue(old('url'))
                )
                ->push(
                  component('FlexGrid')
                    ->withGap(1)
                    ->withWidths('3fr 1fr')
                    ->withItems(
                      collect()
                        ->push(
                          component(!$isPackage ? 'FormTextfield' : 'FormHidden')
                            ->withTitle(trans('offer.admin.edit.guide'))
                            ->withName('guide')
                            ->withValue(old('guide'))
                        )
                        ->push(
                          component(!$isPackage ? 'FormTextfield' : 'FormHidden')
                            ->withTitle(trans('offer.admin.edit.size'))
                            ->withName('size')
                            ->withValue(old('guide'))
                        )
                    )
                )
                ->push(
                  component('FormTextarea')
                    ->withTitle(trans('offer.admin.edit.description'))
                    ->withName('description')
                    ->withValue(old('description'))
                    ->withRows(8)
                )
                ->push(
                  component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                    ->withTitle(trans('offer.admin.edit.accommodation'))
                    ->withName('accommodation')
                    ->withValue(old('accommodation'))
                    ->withRows(4)
                )
                ->push(
                  component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                    ->withTitle(trans('offer.admin.edit.included'))
                    ->withName('included')
                    ->withValue(old('included'))
                    ->withRows(8)
                )
                ->push(
                  component('FormCheckbox')
                    ->withName('flights')
                    ->withTitle(trans('offer.admin.edit.flights'))
                    ->withValue(old('flights'))
                )
                ->push(
                  component(!$isPackage ? 'FormHidden' : 'FormCheckbox')
                    ->withName('transfer')
                    ->withTitle(trans('offer.admin.edit.transfer'))
                    ->withValue(old('transfer'))
                )
                ->push(
                  component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                    ->withTitle(trans('offer.admin.edit.notincluded'))
                    ->withName('notincluded')
                    ->withValue(old('notincluded'))
                    ->withRows(8)
                )
                ->push(
                  component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                    ->withTitle(trans('offer.admin.edit.extras'))
                    ->withName('extras')
                    ->withValue(old('extras'))
                    ->withRows(8)
                )

                ->spacerWhen($isPackage)
                ->pushWhen(
                  $isPackage,
                  component('Title')
                    ->is('small')
                    ->is('gray')
                    ->withTitle(trans('offer.admin.edit.hotel.title'))
                )
                ->pushWhen(
                  $isPackage,
                  component('Body')
                    ->is('gray')
                    ->withBody(trans('offer.admin.edit.hotel.description'))
                )
                ->push(
                  component('FlexGrid')
                    ->withGap(!$isPackage ? 0 : 1)
                    ->withCols(4)
                    ->withWidths('3fr 1fr 2fr 2fr')
                    ->withItems(
                      collect(array_fill(0, 5, null))
                        ->map(function ($value, $key) use ($isPackage, $hasHotelError) {
                          return collect()
                            ->push(
                              component($isPackage ? 'FormTextfield' : 'FormHidden')
                                ->is($key == 0 && $hasHotelError ? 'error' : '')
                                ->withTitle(trans('offer.admin.edit.hotel.name') . ' ' . ($key + 1))
                                ->withName('hotel_name[]')
                              //->withValue('')
                            )
                            ->push(
                              component($isPackage ? 'FormTextfield' : 'FormHidden')
                                ->withTitle(trans('offer.admin.edit.hotel.rating') . ' ' . ($key + 1))
                                ->withName('hotel_rating[]')
                            )
                            ->push(
                              component($isPackage ? 'FormTextfield' : 'FormHidden')
                                ->withTitle(trans('offer.admin.edit.hotel.type') . ' ' . ($key + 1))
                                ->withName('hotel_type[]')
                            )
                            ->push(
                              component($isPackage ? 'FormTextfield' : 'FormHidden')
                                ->is($key == 0 && $hasHotelError ? 'error' : '')
                                ->withTitle(trans('offer.admin.edit.hotel.price') . ' ' . ($key + 1))
                                ->withSuffix(config('site.currency.eur'))
                                ->withName('hotel_price[]')
                            );
                        })
                        ->flatten()
                    )
                )
                ->pushWhen(
                  request()->has('redirect'),
                  component('FormHidden')
                    ->with('name', 'redirect')
                    ->with('value', request()->redirect)
                )
                ->push(
                  component('FormButton')
                    ->is('large')
                    ->is('wide')
                    ->withTitle(trans("offer.admin.create.style.$style"))
                )
            )
        )
      )
      ->with('footer', region('FooterLight'))
      ->render();
  }

  public function edit($id)
  {
    $offer = Offer::findOrFail($id);

    $isPackage = $offer->style == 'package';
    $style = $offer->style;

    $destinations = Destination::select('id', 'name')
      ->orderBy('name', 'asc')
      ->get();

    $hasHotelError = collect(errorKeys() ?? [])
      ->filter(function ($key) {
        return starts_with($key, 'hotel_');
      })
      ->isNotEmpty();

    return layout('Two')
      ->with('color', 'blue')
      ->with(
        'header',
        region(
          'OfferHeader',
          collect()->push(
            component('Title')
              ->is('white')
              ->is('large')
              ->is('center')
              ->withTitle(trans("offer.admin.edit.style.$style"))
          )
        )
      )
      ->with(
        'content',
        collect()->push(
          component('Form')
            ->with('route', route('offer.admin.update', [$id]))
            ->with('method', 'PUT')
            ->with(
              'fields',
              collect()
                ->push(
                  component('FormHidden')
                    ->withName('style')
                    ->withValue($style)
                )
                ->push(
                  component('FormCheckbox')
                    ->withName('status')
                    ->withTitle(trans('offer.admin.edit.status'))
                    ->withValue(old('status', $offer->status))
                )
                ->push(
                  component('FlexGrid')
                    ->withGap($isPackage ? 0 : 1)
                    ->withWidths($isPackage ? '1fr 0' : '2fr 1fr')
                    ->withItems(
                      collect()
                        ->push(
                          component('FormTextfield')
                            ->withTitle(trans('offer.admin.edit.title'))
                            ->withDescription(trans('site.required'))
                            ->withName('title')
                            ->withValue(old('title', $offer->title))
                        )
                        ->push(
                          component($isPackage ? 'FormHidden' : 'FormTextfield')
                            ->withTitle(trans('offer.admin.edit.price'))
                            ->withSuffix(config('site.currency.eur'))
                            ->withDescription($isPackage ? '' : trans('site.required'))
                            ->withName('price')
                            ->withValue(old('price', $offer->price))
                        )
                    )
                )
                ->push(
                  component('FormSelectMultiple')
                    ->with('height', 7)
                    ->withTitle(trans('offer.admin.edit.start_destinations'))
                    ->withDescription(trans('site.required'))
                    ->withName('start_destinations[]')
                    ->with('options', $destinations)
                    ->with('max', 1)
                    ->withValue(old('start_destinations[]', $offer->startDestinations()->pluck('destination_id')))
                )
                ->push(
                  component('FormSelectMultiple')
                    ->with('height', 7)
                    ->withTitle(trans('offer.admin.edit.end_destinations'))
                    ->withDescription(trans('site.required'))
                    ->withName('end_destinations[]')
                    ->with('options', $destinations)
                    ->withValue(old('end_destinations[]', $offer->endDestinations()->pluck('destination_id')))
                )
                ->push(
                  component('FlexGrid')
                    ->withGap(1)
                    ->withItems(
                      collect()
                        ->push(
                          component('FormTextfield')
                            ->withTitle(trans('offer.admin.edit.start_at'))
                            ->withDescription(trans('site.required'))
                            ->with('placeholder', Date::now()->format(config('offer.date.inputformat')))
                            ->withName('start_at')
                            ->withValue(old('start_at', $offer->start_at->format(config('offer.date.inputformat'))))
                        )
                        ->push(
                          component('FormTextfield')
                            ->withTitle(trans('offer.admin.edit.end_at'))
                            ->withDescription(trans('site.required'))
                            ->with('placeholder', Date::now()->format(config('offer.date.inputformat')))
                            ->withName('end_at')
                            ->withValue(old('end_at', $offer->end_at->format(config('offer.date.inputformat'))))
                        )
                    )
                )
                ->push(
                  component('FormTextfield')
                    ->withDescription(!$isPackage ? trans('site.required') : '')
                    ->withTitle(trans('offer.admin.edit.url'))
                    ->withName('url')
                    ->withPlaceholder('http://')
                    ->withValue(old('url', $offer->data->url))
                )
                ->push(
                  component('FlexGrid')
                    ->withGap(1)
                    ->withWidths('3fr 1fr')
                    ->withItems(
                      collect()
                        ->push(
                          component(!$isPackage ? 'FormTextfield' : 'FormHidden')
                            ->withTitle(trans('offer.admin.edit.guide'))
                            ->withName('guide')
                            ->withValue(old('guide', $offer->data->guide))
                        )
                        ->push(
                          component(!$isPackage ? 'FormTextfield' : 'FormHidden')
                            ->withTitle(trans('offer.admin.edit.size'))
                            ->withName('size')
                            ->withValue(old('guide', $offer->data->size))
                        )
                    )
                )
                ->push(
                  component('FormTextarea')
                    ->withTitle(trans('offer.admin.edit.description'))
                    ->withName('description')
                    ->withValue(old('description', $offer->data->description))
                    ->withRows(8)
                )
                ->push(
                  component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                    ->withTitle(trans('offer.admin.edit.accommodation'))
                    ->withName('accommodation')
                    ->withValue(old('accommodation', $offer->data->accommodation))
                    ->withRows(4)
                )
                ->push(
                  component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                    ->withTitle(trans('offer.admin.edit.included'))
                    ->withName('included')
                    ->withValue(old('included', $offer->data->included))
                    ->withRows(8)
                )
                ->push(
                  component('FormCheckbox')
                    ->withName('flights')
                    ->withTitle(trans('offer.admin.edit.flights'))
                    ->withValue(old('flights', $offer->data->flights))
                )
                ->push(
                  component(!$isPackage ? 'FormHidden' : 'FormCheckbox')
                    ->withName('transfer')
                    ->withTitle(trans('offer.admin.edit.transfer'))
                    ->withValue(old('transfer', $offer->data->transfer))
                )
                ->push(
                  component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                    ->withTitle(trans('offer.admin.edit.notincluded'))
                    ->withName('notincluded')
                    ->withValue(old('notincluded', $offer->data->notincluded))
                    ->withRows(8)
                )
                ->push(
                  component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                    ->withTitle(trans('offer.admin.edit.extras'))
                    ->withName('extras')
                    ->withValue(old('extras', $offer->data->extras))
                    ->withRows(8)
                )

                ->spacerWhen($isPackage)
                ->pushWhen(
                  $isPackage,
                  component('Title')
                    ->is('small')
                    ->is('gray')
                    ->withTitle(trans('offer.admin.edit.hotel.title'))
                )
                ->pushWhen(
                  $isPackage,
                  component('Body')
                    ->is('gray')
                    ->withBody(trans('offer.admin.edit.hotel.description'))
                )
                ->push(
                  component('FlexGrid')
                    ->withGap(!$isPackage ? 0 : 1)
                    ->withCols(4)
                    ->withWidths('3fr 1fr 2fr 2fr')
                    ->withItems(
                      collect(array_fill(0, 5, null))
                        ->map(function ($value, $key) use ($isPackage, $hasHotelError, $offer) {
                          return collect()
                            ->push(
                              component($isPackage ? 'FormTextfield' : 'FormHidden')
                                ->is($key == 0 && $hasHotelError ? 'error' : '')
                                ->withTitle(trans('offer.admin.edit.hotel.name') . ' ' . ($key + 1))
                                ->withName('hotel_name[]')
                                ->withValue(
                                  old(
                                    'hotel_name[]',
                                    array_key_exists($key, $offer->data->hotels) ? $offer->data->hotels[$key]->name : ''
                                  )
                                )
                            )
                            ->push(
                              component($isPackage ? 'FormTextfield' : 'FormHidden')
                                ->withTitle(trans('offer.admin.edit.hotel.rating') . ' ' . ($key + 1))
                                ->withName('hotel_rating[]')
                                ->withValue(
                                  old(
                                    'hotel_rating[]',
                                    array_key_exists($key, $offer->data->hotels)
                                      ? $offer->data->hotels[$key]->rating
                                      : ''
                                  )
                                )
                            )
                            ->push(
                              component($isPackage ? 'FormTextfield' : 'FormHidden')
                                ->withTitle(trans('offer.admin.edit.hotel.type') . ' ' . ($key + 1))
                                ->withName('hotel_type[]')
                                ->withValue(
                                  old(
                                    'hotel_type[]',
                                    array_key_exists($key, $offer->data->hotels) ? $offer->data->hotels[$key]->type : ''
                                  )
                                )
                            )
                            ->push(
                              component($isPackage ? 'FormTextfield' : 'FormHidden')
                                ->is($key == 0 && $hasHotelError ? 'error' : '')
                                ->withTitle(trans('offer.admin.edit.hotel.price') . ' ' . ($key + 1))
                                ->withSuffix(config('site.currency.eur'))
                                ->withName('hotel_price[]')
                                ->withValue(
                                  old(
                                    'hotel_price[]',
                                    array_key_exists($key, $offer->data->hotels)
                                      ? $offer->data->hotels[$key]->price
                                      : ''
                                  )
                                )
                            );
                        })
                        ->flatten()
                    )
                )
                ->pushWhen(
                  request()->has('redirect'),
                  component('FormHidden')
                    ->with('name', 'redirect')
                    ->with('value', request()->redirect)
                )
                ->push(
                  component('FormButton')
                    ->is('large')
                    ->is('wide')
                    ->withTitle(trans("offer.admin.edit.style.$style"))
                )
            )
        )
      )
      ->with('footer', region('FooterLight'))
      ->render();
  }

  public function store()
  {
    $loggedUser = request()->user();

    $isPackage = request()->style == 'package';

    $rules = [
      'title' => 'required',
      'start_destinations' => 'required',
      'end_destinations' => 'required',
      'price' => $isPackage ? '' : 'required',
      'url' => $isPackage ? 'url' : 'url|required',
      'hotel_name.0' => $isPackage ? 'required' : '',
      'hotel_price.0' => $isPackage ? 'required' : '',
      'start_at' => 'required|after:now|date_format:' . config('offer.date.inputformat'),
      'end_at' => 'required|after:now|date_format:' . config('offer.date.inputformat')
    ];

    $this->validate(request(), $rules);

    $status = request()->status == 'on';
    $flights = request()->flights == 'on';
    $transfer = request()->transfer == 'on';

    $hotels = collect(request()->only('hotel_name', 'hotel_rating', 'hotel_type', 'hotel_price'))
      ->transpose()
      ->map(function ($h) {
        return (object) collect(['name', 'rating', 'type', 'price'])
          ->zip($h)
          ->fromPairs();
      });
    $offer = $loggedUser->offers()->create([
      'status' => $status,
      'title' => request()->title,
      'style' => request()->style,
      'start_at' => Date::createFromFormat(config('offer.date.inputformat'), request()->start_at),
      'end_at' => Date::createFromFormat(config('offer.date.inputformat'), request()->end_at),
      'data' => [
        'price' => intval(only_numbers(request()->price)) > 0 ? intval(only_numbers(request()->price)) : '',
        'guide' => request()->guide,
        'size' => request()->size,
        'description' => request()->description,
        'url' => request()->url,
        'accommodation' => request()->accommodation,
        'included' => request()->included,
        'notincluded' => request()->notincluded,
        'extras' => request()->extras,
        'flights' => $flights,
        'transfer' => $transfer,
        'hotels' => $hotels
      ]
    ]);

    $offer->startDestinations()->attach(
      collect(request()->start_destinations)->mapWithKeys(function ($value) {
        return [$value[0] => ['type' => 'start']];
      })
    );

    $offer->endDestinations()->attach(
      collect(request()->end_destinations)->mapWithKeys(function ($value) {
        return [$value[0] => ['type' => 'end']];
      })
    );

    Log::info('New offer added', [
      'user' => $offer->user->name,
      'title' => $offer->title,
      'link' => route('offer.show', [$offer])
    ]);

    return redirect()
      ->route(request()->has('redirect') ? request()->redirect : 'company.index')
      ->with(
        'info',
        trans('offer.admin.store.info', [
          'title' => $offer->title
        ])
      );
  }

  public function update($id)
  {
    $offer = Offer::findOrFail($id);

    $loggedUser = request()->user();

    $isPackage = request()->style == 'package';

    $rules = [
      'title' => 'required',
      'start_destinations' => 'required',
      'end_destinations' => 'required',
      'price' => $isPackage ? '' : 'required',
      'url' => $isPackage ? 'url' : 'url|required',
      'hotel_name.0' => $isPackage ? 'required' : '',
      'hotel_price.0' => $isPackage ? 'required' : '',
      'start_at' => 'required|after:now|date_format:' . config('offer.date.inputformat'),
      'end_at' => 'required|after:now|date_format:' . config('offer.date.inputformat')
    ];

    $this->validate(request(), $rules);

    $status = request()->status == 'on';
    $flights = request()->flights == 'on';
    $transfer = request()->transfer == 'on';

    $hotels = collect(request()->only('hotel_name', 'hotel_rating', 'hotel_type', 'hotel_price'))
      ->transpose()
      ->map(function ($h) {
        return (object) collect(['name', 'rating', 'type', 'price'])
          ->zip($h)
          ->fromPairs();
      });

    $offer->update([
      'status' => $status,
      'title' => request()->title,
      'style' => request()->style,
      'start_at' => Date::createFromFormat(config('offer.date.inputformat'), request()->start_at),
      'end_at' => Date::createFromFormat(config('offer.date.inputformat'), request()->end_at),
      'data' => [
        'price' => intval(only_numbers(request()->price)) > 0 ? intval(only_numbers(request()->price)) : '',
        'guide' => request()->guide,
        'size' => request()->size,
        'description' => request()->description,
        'url' => request()->url,
        'accommodation' => request()->accommodation,
        'included' => request()->included,
        'notincluded' => request()->notincluded,
        'extras' => request()->extras,
        'flights' => $flights,
        'transfer' => $transfer,
        'hotels' => $hotels
      ]
    ]);

    $offer->startDestinations()->sync(
      collect(request()->start_destinations)->mapWithKeys(function ($value) {
        return [$value[0] => ['type' => 'start']];
      })
    );

    $offer->endDestinations()->sync(
      collect(request()->end_destinations)->mapWithKeys(function ($value) {
        return [$value[0] => ['type' => 'end']];
      })
    );

    Log::info('New offer added', [
      'user' => $offer->user->name,
      'title' => $offer->title,
      'link' => route('offer.show', [$offer])
    ]);

    return redirect()
      ->route(request()->has('redirect') ? request()->redirect : 'company.index')
      ->with(
        'info',
        trans('offer.admin.update.info', [
          'title' => $offer->title
        ])
      );
  }
}
