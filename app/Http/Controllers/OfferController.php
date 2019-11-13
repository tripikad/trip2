<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

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
                        ->with('dots', config('dots'))
                        ->with('route', route('offers.index.json'))
                )
            )
            ->with('sidebar', '&nbsp;')
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
        $offer = $this->getSheet()[$id];

        return layout('Offer')
            ->with('head_robots', 'noindex')
            ->with('title', 'Offer')
            ->with('color', 'blue')
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
                    component('Body')->with(
                        'body',
                        collect($offer)
                            ->map(function ($value, $key) {
                                return $key . ' : ' . $value;
                            })
                            ->implode('<br>')
                    )
                )
            )
            ->with(
                'sidebar',
                collect()->push(
                    component('Button')
                        ->with('title', trans('offers.show.book'))
                        ->with('route', route('offers.book', $id))
                )
            )
            ->render();
    }

    public function book($id)
    {
        $offer = $this->getSheet()[$id];

        $user = auth()->user();
        $email = $user ? $user->email : '';
        $name = $user && $user->real_name ? $user->real_name : '';

        return layout('Two')
            ->with('head_robots', 'noindex')
            ->with('background', component('BackgroundMap'))
            ->with(
                'header',
                region(
                    'StaticHeader',
                    collect()
                        ->push(
                            component('Link')
                                ->with('title', trans('offers.book.back'))
                                ->with('route', route('offers.show', $id))
                        )
                        ->push(
                            component('Title')
                                ->is('large')
                                ->with('title', trans('offers.book.title'))
                        )
                )
            )
            ->with(
                'content',
                collect()
                    ->push(component('OfferRow')->with('offer', $offer))
                    ->push(
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
                                            ->with(
                                                'title',
                                                'Number of children'
                                            )
                                    )
                                    ->push(
                                        component('FormTextarea')
                                            ->with('name', 'notes')
                                            ->with('title', 'Notes')
                                    )
                                    ->push(
                                        component('FormCheckbox')
                                            ->with('name', 'insurance')
                                            ->with(
                                                'title',
                                                'I need an insurance'
                                            )
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
                                        component('FormButton')->with(
                                            'title',
                                            'Book an offer'
                                        )
                                    )
                            )
                    )
            )
            ->with('sidebar', '&nbsp;')
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
