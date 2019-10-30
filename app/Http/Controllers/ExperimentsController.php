<?php

namespace App\Http\Controllers;

class ExperimentsController extends Controller
{
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

    private function getSheet()
    {
        $id = '1TLEDlvDC_06gy75IhNAyXaUjt-9oOT2XOqW2LEpycHE';

        $url =
            'https://spreadsheets.google.com/feeds/list/' .
            $id .
            '/od6/public/values?alt=json';
        return $this->parseSheet(json_decode(file_get_contents($url)));
    }

    public function index()
    {
        return layout('Two')
            ->with('title', 'Experiments')
            ->with(
                'content',
                collect()->push(
                    component('Code')->with(
                        'code',
                        json_encode($this->getSheet(), JSON_PRETTY_PRINT)
                    )
                )
            )
            ->render();
    }

    public function show($id)
    {
        return layout('Two')
            ->with('title', 'Experiments')
            ->with(
                'content',
                collect()->push(
                    component('Code')->with(
                        'code',
                        json_encode($this->getSheet()[$id], JSON_PRETTY_PRINT)
                    )
                )
            )
            ->render();
    }
}
