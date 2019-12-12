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
                                        ->withValue(old('status'))
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
                                                        ->withName('title')
                                                        ->withValue(old('title'))
                                                )
                                                ->push(
                                                    component($isPackage ? 'FormHidden' : 'FormTextField')
                                                        ->withTitle(trans('offer.admin.edit.price'))
                                                        ->withSuffix(config('site.currency.eur'))
                                                        ->withDescription($isPackage ? '' : trans('site.required'))
                                                        ->withName('price')
                                                        ->withValue(old('price'))
                                                )
                                        )
                                )
                                ->push(
                                    component('FlexGrid')
                                        ->withGap(1)
                                        ->withItems(
                                            collect()
                                                ->push(
                                                    component('FormSelectMultiple')
                                                        ->with('height', 12)
                                                        ->withTitle(trans('offer.admin.edit.start_destinations'))
                                                        ->withName('start_destinations[]')
                                                        ->with('options', $destinations)
                                                        ->with('max', 1)
                                                        ->withValue($startDestination ? [$startDestination->id] : [])
                                                )
                                                ->push(
                                                    component('FormSelectMultiple')
                                                        ->with('height', 12)
                                                        ->withTitle(trans('offer.admin.edit.end_destinations'))
                                                        ->withName('end_destinations[]')
                                                        ->with('options', $destinations)
                                                )
                                        )
                                )
                                ->push(
                                    component('FlexGrid')
                                        ->withGap(1)
                                        ->withItems(
                                            collect()
                                                ->push(
                                                    component('FormTextfield')
                                                        ->withTitle(trans('offer.admin.edit.start_at'))
                                                        ->with(
                                                            'placeholder',
                                                            Date::now()->format(config('offer.date.inputformat'))
                                                        )
                                                        ->withName('start_at')
                                                        ->withValue(old('start_at'))
                                                )
                                                ->push(
                                                    component('FormTextfield')
                                                        ->withTitle(trans('offer.admin.edit.end_at'))
                                                        ->with(
                                                            'placeholder',
                                                            Date::now()->format(config('offer.date.inputformat'))
                                                        )
                                                        ->withName('end_at')
                                                        ->withValue(old('end_at'))
                                                )
                                        )
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
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->withName('transfer')
                                        ->withTitle(trans('offer.admin.edit.transfer'))
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
                                                                ->withTitle(
                                                                    trans('offer.admin.edit.hotel.name') .
                                                                        ' ' .
                                                                        ($key + 1)
                                                                )
                                                                ->withName('hotel_name[]')
                                                            //->withValue('')
                                                        )
                                                        ->push(
                                                            component($isPackage ? 'FormTextfield' : 'FormHidden')
                                                                ->withTitle(
                                                                    trans('offer.admin.edit.hotel.rating') .
                                                                        ' ' .
                                                                        ($key + 1)
                                                                )
                                                                ->withName('hotel_rating[]')
                                                        )
                                                        ->push(
                                                            component($isPackage ? 'FormTextfield' : 'FormHidden')
                                                                ->withTitle(
                                                                    trans('offer.admin.edit.hotel.type') .
                                                                        ' ' .
                                                                        ($key + 1)
                                                                )
                                                                ->withName('hotel_type[]')
                                                        )
                                                        ->push(
                                                            component($isPackage ? 'FormTextfield' : 'FormHidden')
                                                                ->is($key == 0 && $hasHotelError ? 'error' : '')
                                                                ->withTitle(
                                                                    trans('offer.admin.edit.hotel.price') .
                                                                        ' ' .
                                                                        ($key + 1)
                                                                )
                                                                ->withSuffix(config('site.currency.eur'))
                                                                ->withName('hotel_price[]')
                                                        );
                                                })
                                                ->flatten()
                                        )
                                )

                                ->push(
                                    component('FormButton')
                                        ->is('large')
                                        ->is('orange')
                                        ->withTitle(trans("offer.admin.create.style.$style"))
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
                'price' => string2int(request()->price) > 0 ? string2int(request()->price) : '',
                'guide' => request()->guide,
                'size' => request()->size,
                'accommodation' => request()->accommodation,
                'included' => request()->included,
                'notincluded' => request()->notincluded,
                'extras' => request()->extras,
                'description' => request()->description,
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
            ->route('company.index')
            ->with(
                'info',
                trans('offer.admin.store.info', [
                    'title' => $offer->title
                ])
            );
    }
}
