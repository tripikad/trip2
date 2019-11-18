<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;

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
                    collect()->push(
                        component('Title')
                            ->is('large')
                            ->is('white')
                            ->is('center')
                            ->with('title', trans('offers.index.title'))
                    )
                )
            )
            ->with(
                'content',
                collect()->push(
                    component('OfferList')
                        ->with('height', '200vh')
                        ->with('countrydots', config('countrydots'))
                        ->with('route', route('offers.index.json'))
                )
            )
            ->with('footer', region('FooterLight', ''))
            ->render();
    }

    public function indexJson()
    {
        $data = $this->getSheet()->map(function ($item, $index) {
            $item->route = route('offers.show', $index);
            return $item;
        });

        return response()->json($data);
    }

    public function show($id)
    {
        $offer = (object) $this->getSheet()[$id];

        //dd($offer);

        $name = $offer->startfrom ? $offer->startfrom : 'Tallinn';
        $startDestination = Destination::where('name', $name)->first();
        //dd($startDestination->vars()->facts());

        $name = collect(explode(',', $offer->destination))
            ->map(function ($s) {
                return trim($s);
            })
            ->last();

        $destination = Destination::where('name', $name)->first();

        $photos = $destination
            ? Content::getLatestPagedItems('photo', 18, $destination->id)
            : collect();

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
                        component('Flex')
                            ->is('center')
                            ->with(
                                'items',
                                collect()->push(
                                    component('Link')
                                        ->is('white')
                                        ->is('semitransparent')
                                        ->with('title', 'Kõik reisipakkumised')
                                        ->with('route', route('offers.index'))
                                )
                            )
                    )
                    ->push(
                        component('Dotmap')
                            ->is('center')
                            ->with('height', '300px')
                            ->with('countrydots', config('countrydots'))
                            ->with(
                                'destination_facts',
                                config('destination_facts')
                            )

                            ->with('lines', [
                                $startDestination->vars()->facts(),
                                [
                                    'lat' => $offer->latitude,
                                    'lon' => $offer->longitude
                                ]
                            ])
                            ->with('mediumdots', [
                                $startDestination->vars()->facts()
                            ])
                            ->with('largedots', [
                                [
                                    'lat' => $offer->latitude,
                                    'lon' => $offer->longitude
                                ]
                            ])
                    )
                    ->push(
                        component('Flex')
                            ->is('center')
                            ->with(
                                'items',
                                collect()->push(
                                    component('Tag')
                                        ->is('white')
                                        ->is('large')
                                        ->with('title', $offer->style)
                                )
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
                            ->is('center')
                            ->with(
                                'items',
                                collect()
                                    ->push(
                                        component('Title')
                                            ->is('small')
                                            ->is('center')
                                            ->is('white')
                                            ->with('title', $offer->duration)
                                    )
                                    ->push(
                                        component('Title')
                                            ->is('small')
                                            ->is('center')
                                            ->is('white')
                                            ->is('semitransparent')
                                            ->with(
                                                'title',
                                                $offer->from .
                                                    ' → ' .
                                                    $offer->to
                                            )
                                    )
                            )
                    )
                    ->push(
                        component('Flex')
                            ->is('center')
                            ->with('gap', 'sm')
                            ->with(
                                'items',
                                collect()
                                    ->pushWhen(
                                        $offer->company !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->is('semitransparent')
                                            ->with('title', 'Firma')
                                    )
                                    ->pushWhen(
                                        $offer->company !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->with('title', $offer->company)
                                    )
                                    ->pushWhen(
                                        $offer->guide !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->is('semitransparent')
                                            ->with('title', 'Giid')
                                    )
                                    ->pushWhen(
                                        $offer->guide !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->with('title', $offer->guide)
                                    )
                                    ->pushWhen(
                                        $offer->people !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->is('semitransparent')
                                            ->with('title', 'Grupi suurus')
                                    )
                                    ->pushWhen(
                                        $offer->people !== '',
                                        component('Title')
                                            ->is('smallest')
                                            ->is('white')
                                            ->with('title', $offer->people)
                                    )
                            )
                    )
                    ->push(
                        component('Flex')
                            ->is('center')
                            ->with(
                                'items',
                                collect()->push(
                                    component('Button')
                                        ->is('orange')
                                        ->is('center')
                                        ->is('large')
                                        ->with('title', 'Broneeri reis')
                                        ->with(
                                            'route',
                                            route('offers.show', [$id]) .
                                                '#book'
                                        )
                                )
                            )
                    )
                    ->br()
                    ->pushWhen(
                        $photos->count(),
                        region(
                            'PhotoRow',
                            $photos->count() < 18
                                ? $photos->slice(0, 9)
                                : $photos
                        )
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
                        ->with('route', route('offers.send', $id))
                        ->with(
                            'fields',
                            collect()
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'name')
                                        ->with('title', 'Name')
                                        ->with('value', $name)
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'email')
                                        ->with('title', 'E-mail')
                                        ->with('value', $email)
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'phone')
                                        ->with('title', 'Phone')
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'adults')
                                        ->with('title', 'Number of adults')
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('name', 'children')
                                        ->with('title', 'Number of children')
                                )
                                ->push(
                                    component('FormTextarea')
                                        ->with('name', 'notes')
                                        ->with('title', 'Notes')
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'insurance')
                                        ->with('title', 'I need an insurance')
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'installments')
                                        ->with(
                                            'title',
                                            'I want to pay by installments'
                                        )
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('name', 'flexible')
                                        ->with(
                                            'title',
                                            'I am flexible with dates (+-3 days)'
                                        )
                                )
                                ->push(
                                    component('FormButton')
                                        ->is('orange')
                                        ->is('wide')
                                        ->is('large')
                                        ->with('title', 'Book an offer')
                                )
                        )
                )
            )
            ->with('footer', region('FooterLight', ''))
            ->render();
    }

    public function send($id)
    {
        return redirect()
            ->route('offers.index')
            ->with('info', 'The booking was sent');
    }

    private function getSheet()
    {
        $id = '1TLEDlvDC_06gy75IhNAyXaUjt-9oOT2XOqW2LEpycHE';

        $url =
            'https://spreadsheets.google.com/feeds/list/' .
            $id .
            '/od6/public/values?alt=json';

        //return Cache::remember('sheet', 0, function () use ($url) {
        return $this->parseSheet(json_decode(file_get_contents($url)));
        //});
    }

    private function parseSheet($data)
    {
        return collect($data->feed->entry)->map(function ($entry) {
            return (object) collect($entry)
                ->keys()
                ->map(function ($field) use ($entry) {
                    if (starts_with($field, 'gsx$')) {
                        return [
                            str_replace('gsx$', '', $field),
                            $entry->{$field}->{'$t'}
                        ];
                    } else {
                        return false;
                    }
                })
                ->filter(function ($field) {
                    return $field;
                })
                ->reduce(function ($carry, $field) {
                    return $carry->put($field[0], $field[1]);
                }, collect())
                ->toArray();
        });
    }
}
