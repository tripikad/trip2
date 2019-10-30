<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class OfferController extends Controller
{
    public function index()
    {
        return layout('Two')
            ->with('head_robots', 'noindex')
            ->with('background', component('BackgroundMap'))

            ->with(
                'header',
                region(
                    'StaticHeader',
                    collect()->push(
                        component('Title')
                            ->is('large')
                            ->with('title', trans('offers.index.title'))
                    )
                )
            )
            ->with(
                'content',
                collect()->push(
                    component('Offers')->with(
                        'route',
                        route('offers.index.json')
                    )
                )
            )
            ->with('sidebar', '&nbsp;')
            ->render();
    }

    public function indexJson()
    {
        $data = $this->getSheet()->map(function ($item, $index) {
            $item->put('route', route('offers.show', $index));
            return $item;
        });

        return response()->json($data);
    }

    public function show($id)
    {
        return layout('Two')
            ->with('title', 'Offer')
            ->with(
                'content',
                collect()->push(
                    component('Code')->with(
                        'code',
                        json_encode($this->getSheet()[$id], JSON_PRETTY_PRINT)
                    )
                )
            )
            ->with('sidebar', '&nbsp;')
            ->render();
    }

    private function getSheet()
    {
        $id = '1TLEDlvDC_06gy75IhNAyXaUjt-9oOT2XOqW2LEpycHE';

        $url =
            'https://spreadsheets.google.com/feeds/list/' .
            $id .
            '/od6/public/values?alt=json';

        return Cache::remember('sheet', 1, function () use ($url) {
            return $this->parseSheet(json_decode(file_get_contents($url)));
        });
    }

    private function parseSheet($data)
    {
        return collect($data->feed->entry)->map(function ($entry) {
            return collect($entry)
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
                }, collect());
        });
    }
}
