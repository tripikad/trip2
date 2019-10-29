<?php

namespace App\Http\Controllers;

class ExperimentsController extends Controller
{
    /*
    export const parseSheets = data => {
    return data.feed.entry.map(entry => {
        return Object.keys(entry)
            .map(field => {
                if (field.startsWith('gsx$')) {
                    return [
                        field.split('$')[1],
                        entry[field].$t
                    ]
                }
            })
            .filter(field => field)
            .reduce((field, item) => {
                field[item[0]] = item[1]
                return field
            }, {})
    })
}
    */
    private function parse($data)
    {
        $d = collect($data->feed->entry)->map(function ($entry) {
            return collect($entry)
                ->keys()
                ->map(function ($field) use ($entry) {
                    if (starts_with($field, 'gsx$')) {
                        return [$field, $entry->{$field}->{'$t'}];
                    } else {
                        return false;
                    }
                });
        });

        dd($d);
    }

    private function code()
    {
        $id = '1TLEDlvDC_06gy75IhNAyXaUjt-9oOT2XOqW2LEpycHE';
        $url =
            'https://spreadsheets.google.com/feeds/list/' .
            $id .
            '/od6/public/values?alt=json';
        $this->parse(json_decode(file_get_contents($url)));
        //return $data;
    }

    public function index()
    {
        $this->code();

        return layout('Two')
            ->with('title', 'Experiments')
            ->with(
                'content',
                collect()->push(
                    component('Code')->with(
                        'code',
                        json_encode($this->code(), JSON_PRETTY_PRINT)
                    )
                )
            )
            ->render();
    }
}
