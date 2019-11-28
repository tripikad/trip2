<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Content;
use App\Offer;
use App\Destination;
use App\Mail\OfferBooking;

use Log;
use Mail;

class OfferController extends Controller
{
    public function index()
    {
        return layout('Offer')
            ->with('color', 'blue')
            ->with('head_robots', 'noindex')
            ->with(
                'header',
                region(
                    'OfferHeader',
                    collect()
                        ->push(
                            component('Title')
                                ->is('large')
                                ->is('white')
                                ->is('center')
                                ->with('title', trans('offer.index'))
                        )
                        ->push(
                            component('FlexGrid')
                                ->with('cols', collect(config('offer.styles'))->count())
                                ->with(
                                    'items',
                                    collect(config('offer.styles'))
                                        ->map(function ($style) {
                                            return component('Button')
                                                ->with('title', trans("offer.create.style.$style"))
                                                ->with('route', route('offer.create', [$style]));
                                        })
                                        ->push('&nbsp;')
                                )
                        )
                )
            )
            ->with(
                'content',
                collect()->push(
                    component('OfferList')
                        ->with('height', '200vh')
                        ->with('route', route('offer.index.json'))
                )
            )
            ->with('footer', region('FooterLight', ''))
            ->render();
    }

    public function indexJson()
    {
        $data = Offer::public()
            ->latest()
            ->with(['user:id,name', 'startDestinations', 'endDestinations'])
            ->get()
            ->map(function ($offer) {
                $offer->route = route('offer.show', $offer);
                $image = $offer->endDestinations
                    ->first()
                    ->content()
                    ->whereType('photo')
                    ->whereStatus(1)
                    ->first();
                $offer->image = $image ? $image->imagePreset('small_square') : '';
                return $offer;
            });

        return response()->json($data);
    }

    public function show($id)
    {
        $offer = Offer::findOrFail($id);

        $photos = Content::getLatestPagedItems('photo', 9, $offer->endDestinations->first()->id);

        $user = auth()->user();
        $email = $user ? $user->email : '';
        $name = $user && $user->real_name ? $user->real_name : '';

        return layout('Offer')
            ->with('head_robots', 'noindex')
            ->with('title', 'Offer')
            ->with('color', 'blue')
            ->with('header', region('OfferHeader'))
            ->with(
                'top',
                collect()
                    ->push(
                        component('Center')->with(
                            'item',
                            component('Link')
                                ->is('white')
                                ->is('semitransparent')
                                ->with('title', 'Kõik reisipakkumised')
                                ->with('route', route('offer.index'))
                        )
                    )
                    ->push(
                        component('Dotmap')
                            ->is('center')
                            ->with('height', '300px')
                            ->with('destination_facts', config('destination_facts'))

                            ->with('lines', [
                                $offer->startDestinations
                                    ->first()
                                    ->vars()
                                    ->coordinates(),
                                $offer->endDestinations
                                    ->first()
                                    ->vars()
                                    ->coordinates()
                            ])
                            ->with('mediumdots', [
                                $offer->startDestinations
                                    ->first()
                                    ->vars()
                                    ->coordinates()
                            ])
                            ->with('largedots', [
                                $offer->endDestinations
                                    ->first()
                                    ->vars()
                                    ->coordinates()
                            ])
                    )
                    ->push(
                        component('Center')->with(
                            'item',
                            component('Tag')
                                ->is('white')
                                ->is('large')
                                ->with('title', $offer->style_formatted)
                        )
                    )
                    ->push(
                        component('Title')
                            ->is('large')
                            ->is('white')
                            ->is('center')
                            ->with('title', $offer->title . ' ' . $offer->price)
                    )
                    ->push(
                        component('Flex')
                            ->with('justify', 'center')
                            ->with(
                                'items',
                                collect()
                                    ->push(
                                        component('Title')
                                            ->is('small')
                                            ->is('center')
                                            ->is('white')
                                            ->with('title', $offer->duration_formatted)
                                    )
                                    ->push(
                                        component('Title')
                                            ->is('small')
                                            ->is('center')
                                            ->is('white')
                                            ->is('semitransparent')
                                            ->with(
                                                'title',
                                                $offer->start_at_formatted . ' → ' . $offer->end_at_formatted
                                            )
                                    )
                            )
                    )
                    ->br()
                    ->push(
                        component('Flex')
                            ->with('justify', 'center')
                            ->with('gap', 'sm')
                            ->with(
                                'items',
                                collect()
                                    ->push(
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->is('semitransparent')
                                            ->with('title', 'Firma')
                                    )
                                    ->push(
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->with('title', $offer->user->name)
                                    )
                                    ->pushWhen(
                                        $offer->data->guide !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->is('semitransparent')
                                            ->with('title', 'Giid')
                                    )
                                    ->pushWhen(
                                        $offer->data->guide !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->with('title', $offer->data->guide)
                                    )
                                    ->pushWhen(
                                        $offer->data->size !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->is('semitransparent')
                                            ->with('title', 'Grupi suurus')
                                    )
                                    ->pushWhen(
                                        $offer->data->size !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->with('title', $offer->data->size)
                                    )
                            )
                    )
                    ->br()
                    ->push(
                        component('Center')->with(
                            'item',
                            component('Button')
                                ->is('orange')
                                ->is('center')
                                ->is('large')
                                ->with('title', 'Broneeri reis')
                                ->with('route', route('offer.show', [$id]) . '#book')
                        )
                    )
                    ->br()
                    ->pushWhen(
                        $photos->count(),
                        region('PhotoRow', $photos->count() < 18 ? $photos->slice(0, 9) : $photos)
                    )
                    ->push('<a id="book"></a>')
                    ->br()
                    ->push(
                        component('Title')
                            ->is('center')
                            ->is('white')
                            ->with('title', 'Broneeri reis')
                    )
                    ->br()
            )
            ->with(
                'bottom',
                collect()->push(
                    component('Form')
                        ->with('route', route('booking.create', $id))
                        ->with(
                            'fields',
                            collect()
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'name')
                                        ->with('title', trans('offer.book.name'))
                                        ->with('value', $name)
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'email')
                                        ->with('title', trans('offer.book.email'))
                                        ->with('value', $email)
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'phone')
                                        ->with('title', trans('offer.book.phone'))
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'adults')
                                        ->with('title', trans('offer.book.adults'))
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'children')
                                        ->with('title', trans('offer.book.children'))
                                )
                                ->push(
                                    component('FormTextarea')
                                        ->with('name', 'notes')
                                        ->with('title', trans('offer.book.notes'))
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'insurance')
                                        ->with('title', trans('offer.book.insurance'))
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'installments')
                                        ->with('title', trans('offer.book.installments'))
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'flexible')
                                        ->with('title', trans('offer.book.flexible'))
                                )
                                ->push(
                                    component('FormButton')
                                        ->is('orange')
                                        ->is('wide')
                                        ->is('large')
                                        ->with('title', trans('offer.book.submit'))
                                )
                        )
                )
            )
            ->with('footer', region('FooterLight', ''))
            ->render();
    }

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
                            ->with('title', trans("offer.create.style.$style"))
                    )
                )
            )
            ->with(
                'content',
                collect()->push(
                    component('Form')
                        ->with('route', route('offer.store'))
                        ->with(
                            'fields',
                            collect()
                                ->push(
                                    component('FormHidden')
                                        ->with('name', 'style')
                                        ->with('value', $style)
                                )

                                ->push(
                                    component('FormTextfield')
                                        ->with('title', trans('offer.edit.title'))
                                        ->with('name', 'title')
                                        ->with('value', old('title'))
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('title', trans('offer.edit.price'))
                                        ->with('name', 'price')
                                        ->with('value', old('price'))
                                )

                                ->push(
                                    component('Flex')->with(
                                        'items',
                                        collect()
                                            ->push(
                                                component('FormSelect')
                                                    ->with('height', 12)
                                                    ->with('title', trans('offer.edit.start_destination'))
                                                    ->with('name', 'start_destination')
                                                    ->with('options', $destinations)

                                                    ->with('value', $startDestination->id)
                                            )
                                            ->push(
                                                component('FormSelectMultiple')
                                                    ->with('title', trans('offer.edit.end_destination'))
                                                    ->with('name', 'end_destinations[]')
                                                    ->with('options', $destinations)
                                            )
                                    )
                                )
                                ->push(
                                    component('Flex')->with(
                                        'items',
                                        collect()
                                            ->push(
                                                component('FormTextfield')
                                                    ->with('title', trans('offer.edit.start_at'))
                                                    ->with('name', 'start_at')

                                                    ->with('value', $startDestination->id)
                                            )
                                            ->push(
                                                component('FormTextfield')
                                                    ->with('title', trans('offer.edit.end_at'))
                                                    ->with('name', 'end_at')
                                                    ->with('options', $destinations)
                                            )
                                    )
                                )
                                ->push(
                                    component('Flex')
                                        ->with('gap', !$isPackage ? 1 : 0)
                                        ->with('widths', '3fr 1fr')
                                        ->with(
                                            'items',
                                            collect()
                                                ->push(
                                                    component(!$isPackage ? 'FormTextfield' : 'FormHidden')
                                                        ->with('title', trans('offer.edit.guide'))
                                                        ->with('name', 'guide')

                                                        ->with('value', old('guide'))
                                                )
                                                ->push(
                                                    component(!$isPackage ? 'FormTextfield' : 'FormHidden')
                                                        ->with('title', trans('offer.edit.size'))
                                                        ->with('name', 'size')

                                                        ->with('value', old('guide'))
                                                )
                                        )
                                )
                                ->push(
                                    component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                                        ->with('title', trans('offer.edit.accommodation'))
                                        ->with('name', 'accommodation')
                                        ->with('value', old('accommodation'))
                                        ->with('rows', 4)
                                )
                                ->push(
                                    component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                                        ->with('title', trans('offer.edit.included'))
                                        ->with('name', 'included')
                                        ->with('value', old('included'))
                                        ->with('rows', 4)
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'flights')
                                        ->with('title', trans('offer.edit.flights'))
                                )
                                ->push(
                                    component(!$isPackage ? 'FormTextarea' : 'FormHidden')
                                        ->with('title', trans('offer.edit.extras'))
                                        ->with('name', 'extras')
                                        ->with('value', old('extras'))
                                        ->with('rows', 4)
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'transfer')
                                        ->with('title', trans('offer.edit.transfer'))
                                )
                                ->push(
                                    component('Flex')
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
                                                                    $key == 0 ? trans('offer.edit.hotel.name') : ''
                                                                )
                                                                ->with('name', 'hotel_name[]')
                                                                ->with('value', old('hotel_name'))
                                                        )
                                                        ->push(
                                                            component($isPackage ? 'FormTextfield' : 'FormHidden')
                                                                ->with(
                                                                    'title',
                                                                    $key == 0 ? trans('offer.edit.hotel.rating') : ''
                                                                )
                                                                ->with('name', 'hotel_rating[]')
                                                                ->with('options', old('hotel_rating'))
                                                        )
                                                        ->push(
                                                            component($isPackage ? 'FormTextfield' : 'FormHidden')
                                                                ->with(
                                                                    'title',
                                                                    $key == 0 ? trans('offer.edit.hotel.type') : ''
                                                                )
                                                                ->with('name', 'hotel_type[]')
                                                                ->with('options', old('hotel_type'))
                                                        )
                                                        ->push(
                                                            component($isPackage ? 'FormTextfield' : 'FormHidden')
                                                                ->with(
                                                                    'title',
                                                                    $key == 0 ? trans('offer.edit.hotel.price') : ''
                                                                )
                                                                ->with('name', 'hotel_price[]')
                                                                ->with('options', old('hotel_price'))
                                                        );
                                                })
                                                ->flatten()
                                        )
                                )
                                ->push(
                                    component('FormTextarea')
                                        ->with('title', trans('offer.edit.description'))
                                        ->with('name', 'description')
                                        ->with('value', old('description'))
                                        ->with('rows', 4)
                                )
                                ->push(component('FormButton')->with('title', trans("offer.create.style.$style")))
                        )
                )
            )
            ->render();
    }

    public function store()
    {
        //dd(request()->all());
        $loggedUser = request()->user();

        $rules = [
            'title' => 'required'
            // 'start_destination' => 'required',
            // 'end_destinations' => 'required'
        ];

        $this->validate(request(), $rules);

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
            'price' => request()->get('price'),
            'title' => request()->get('title'),
            'style' => request()->get('style'),
            'start_at' => Carbon::now()->addMonths(2),
            'end_at' => Carbon::now()->addMonths(3),

            'data' => [
                'guide' => request()->get('guide'),
                'size' => request()->get('size'),
                'accommodation' => request()->get('accommodation'),
                'included' => request()->get('included'),
                'extras' => request()->get('extras'),
                'description' => request()->get('description'),
                'flights' => $flights,
                'transfer' => $transfer,
                'hotels' => $hotels
            ],
            'status' => 1
        ]);

        $offer->startDestinations()->attach(
            collect([request()->get('start_destination')])->mapWithKeys(function ($key) {
                return [$key => ['type' => 'start']];
            })
        );

        $offer->endDestinations()->attach(
            collect(request()->get('end_destinations'))->mapWithKeys(function ($key) {
                return [$key => ['type' => 'end']];
            })
        );

        Log::info('New offer added', [
            'user' => $offer->user->name,
            'title' => $offer->title,
            'link' => route('offer.show', [$offer])
        ]);

        return redirect()
            ->route('offer.index')
            ->with(
                'info',
                trans('offer.store.info', [
                    'title' => $offer->title
                ])
            );
    }

    public function book($id)
    {
        $user = auth()->user();

        $offer = (new Offer())->find($id);

        $booking = (object) request()->only('name', 'email', 'phone', 'adults', 'children', 'notes');

        $booking->id = 1;

        $booking->insurance = request()->get('insurance') == 'on';
        $booking->installments = request()->get('installments') == 'on';
        $booking->flexible = request()->get('flexible') == 'on';

        //return new OfferBooking($offer, $booking);

        Mail::to($offer->companyemail)->queue(new OfferBooking($offer, $booking));

        return redirect()
            ->route('offer.index')
            ->with('info', 'The booking was sent');
    }
}
