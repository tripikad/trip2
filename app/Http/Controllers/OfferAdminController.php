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
                            ->with('title', trans("offer.admin.create.style.$style"))
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
                                        ->with('name', 'style')
                                        ->with('value', $style)
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'status')
                                        ->with('title', trans('offer.admin.edit.status'))
                                        ->with('value', old('status'))
                                )
                                ->push(
                                    component('FlexGrid')
                                        ->with('widths', '6fr 1fr')
                                        ->with(
                                            'items',
                                            collect()
                                                ->push(
                                                    component('FormTextfield')
                                                        ->with('title', trans('offer.admin.edit.title'))
                                                        ->with('name', 'title')
                                                        ->with('value', old('title'))
                                                )
                                                ->push(
                                                    component('FormTextField')
                                                        ->with('title', trans('offer.admin.edit.price'))
                                                        ->with('name', 'price')
                                                        ->with('value', old('price'))
                                                )
                                        )
                                )
                                ->push(
                                    component('FlexGrid')->with(
                                        'items',
                                        collect()
                                            ->push(
                                                component('FormSelectMultiple')
                                                    ->with('height', 12)
                                                    ->with('title', trans('offer.admin.edit.start_destinations'))
                                                    ->with('name', 'start_destinations[]')
                                                    ->with('options', $destinations)
                                                    ->with('max', 1)
                                                    ->with('value', $startDestination ? [$startDestination->id] : [])
                                            )
                                            ->push(
                                                component('FormSelectMultiple')
                                                    ->with('height', 12)
                                                    ->with('title', trans('offer.admin.edit.end_destinations'))
                                                    ->with('name', 'end_destinations[]')
                                                    ->with('options', $destinations)
                                            )
                                    )
                                )
                                ->push(
                                    component('FlexGrid')->with(
                                        'items',
                                        collect()
                                            ->push(
                                                component('FormTextfield')
                                                    ->with('title', trans('offer.admin.edit.start_at'))
                                                    ->with(
                                                        'placeholder',
                                                        Date::now()->format(config('offer.date.inputformat'))
                                                    )
                                                    ->with('name', 'start_at')
                                                    ->with('value', old('start_at'))
                                            )
                                            ->push(
                                                component('FormTextfield')
                                                    ->with('title', trans('offer.admin.edit.end_at'))
                                                    ->with(
                                                        'placeholder',
                                                        Date::now()->format(config('offer.date.inputformat'))
                                                    )
                                                    ->with('name', 'end_at')
                                                    ->with('value', old('end_at'))
                                            )
                                    )
                                )
                                ->push(
                                    component('FlexGrid')
                                        ->with('widths', '3fr 1fr')
                                        ->with(
                                            'items',
                                            collect()
                                                ->push(
                                                    component(!$isPackage ? 'FormTextfield' : 'FormHidden')
                                                        ->with('title', trans('offer.admin.edit.guide'))
                                                        ->with('name', 'guide')

                                                        ->with('value', old('guide'))
                                                )
                                                ->push(
                                                    component(!$isPackage ? 'FormTextfield' : 'FormHidden')
                                                        ->with('title', trans('offer.admin.edit.size'))
                                                        ->with('name', 'size')

                                                        ->with('value', old('guide'))
                                                )
                                        )
                                )
                                ->push(
                                    component('FormTextarea')
                                        ->with('title', trans('offer.admin.edit.description'))
                                        ->with('name', 'description')
                                        ->with('value', old('description'))
                                        ->with('rows', 8)
                                )
                                ->push(
                                    component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                                        ->with('title', trans('offer.admin.edit.included'))
                                        ->with('name', 'included')
                                        ->with('value', old('included'))
                                        ->with('rows', 8)
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'flights')
                                        ->with('title', trans('offer.admin.edit.flights'))
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'transfer')
                                        ->with('title', trans('offer.admin.edit.transfer'))
                                )
                                ->push(
                                    component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                                        ->with('title', trans('offer.admin.edit.notincluded'))
                                        ->with('name', 'notincluded')
                                        ->with('value', old('notincluded'))
                                        ->with('rows', 8)
                                )
                                ->push(
                                    component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                                        ->with('title', trans('offer.admin.edit.extras'))
                                        ->with('name', 'extras')
                                        ->with('value', old('extras'))
                                        ->with('rows', 8)
                                )
                                ->push(
                                    component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                                        ->with('title', trans('offer.admin.edit.accommodation'))
                                        ->with('name', 'accommodation')
                                        ->with('value', old('accommodation'))
                                        ->with('rows', 2)
                                )
                                ->push(
                                    component('FlexGrid')
                                        ->with('gap', !$isPackage ? 0 : 1)
                                        ->with('cols', 4)
                                        ->with('widths', '3fr 1fr 2fr 2fr')
                                        ->with(
                                            'items',
                                            collect(array_fill(0, 5, null))
                                                ->map(function ($value, $key) use ($isPackage) {
                                                    return collect()
                                                        ->push(
                                                            component($isPackage ? 'FormTextfield' : 'FormHidden')
                                                                ->with(
                                                                    'title',
                                                                    trans('offer.admin.edit.hotel.name') .
                                                                        ' ' .
                                                                        ($key + 1)
                                                                )
                                                                ->with('name', 'hotel_name[]')
                                                            //->with('value', '')
                                                        )
                                                        ->push(
                                                            component($isPackage ? 'FormTextfield' : 'FormHidden')
                                                                ->with(
                                                                    'title',
                                                                    trans('offer.admin.edit.hotel.rating') .
                                                                        ' ' .
                                                                        ($key + 1)
                                                                )
                                                                ->with('name', 'hotel_rating[]')
                                                            //->with('options', '')
                                                        )
                                                        ->push(
                                                            component($isPackage ? 'FormTextfield' : 'FormHidden')
                                                                ->with(
                                                                    'title',
                                                                    trans('offer.admin.edit.hotel.type') .
                                                                        ' ' .
                                                                        ($key + 1)
                                                                )
                                                                ->with('name', 'hotel_type[]')
                                                            //->with('options','')
                                                        )
                                                        ->push(
                                                            component($isPackage ? 'FormTextfield' : 'FormHidden')
                                                                ->with(
                                                                    'title',
                                                                    trans('offer.admin.edit.hotel.price') .
                                                                        ' ' .
                                                                        ($key + 1)
                                                                )
                                                                ->with('name', 'hotel_price[]')
                                                            //->with('options', '')
                                                        );
                                                })
                                                ->flatten()
                                        )
                                )

                                ->push(
                                    component('FormButton')
                                        ->is('large')
                                        ->is('orange')
                                        ->with('title', trans("offer.admin.create.style.$style"))
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

        $rules = [
            'title' => 'required',
            'start_destinations' => 'required',
            'end_destinations' => 'required',
            'start_at' => 'required|after:now|date_format:' . config('offer.date.inputformat'),
            'end_at' => 'required|after:now|date_format:' . config('offer.date.inputformat')
        ];

        // date|after:now|

        // Date::parse($this->start_at)->format('j. M Y');
        // $rule['date'] = 'required|date_format:d.m.Y';
        // Carbon::createFromFormat('d.m.Y', trim($o->to));
        // use Jenssegers\Date\Date;

        $this->validate(request(), $rules);

        $status = request()->get('status') == 'on';
        $flights = request()->get('flights') == 'on';
        $transfer = request()->get('transfer') == 'on';

        $hotels = collect(request()->only('hotel_name', 'hotel_rating', 'hotel_type', 'hotel_price'))
            ->transpose()
            ->map(function ($h) {
                return (object) collect(['name', 'rating', 'type', 'price'])
                    ->zip($h)
                    ->fromPairs();
            });

        $offer = $loggedUser->offers()->create([
            'status' => $status,
            'title' => request()->get('title'),
            'style' => request()->get('style'),
            'start_at' => Date::createFromFormat(config('offer.date.inputformat'), request()->start_at),
            'end_at' => Date::createFromFormat(config('offer.date.inputformat'), request()->end_at),
            'data' => [
                'price' => request()->get('price'),
                'guide' => request()->get('guide'),
                'size' => request()->get('size'),
                'accommodation' => request()->get('accommodation'),
                'included' => request()->get('included'),
                'notincluded' => request()->get('notincluded'),
                'extras' => request()->get('extras'),
                'description' => request()->get('description'),
                'flights' => $flights,
                'transfer' => $transfer,
                'hotels' => $hotels
            ]
        ]);

        $offer->startDestinations()->attach(
            collect(request()->get('start_destinations'))->mapWithKeys(function ($value) {
                return [$value[0] => ['type' => 'start']];
            })
        );

        $offer->endDestinations()->attach(
            collect(request()->get('end_destinations'))->mapWithKeys(function ($value) {
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
