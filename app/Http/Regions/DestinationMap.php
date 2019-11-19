<?php

namespace App\Http\Regions;

class DestinationMap
{
    public function render($destination)
    {
        $areas = [];
        $largedots = [];
        $smalldots = [];

        if ($destination->vars()->isContinent()) {
            $areas = $destination
                ->vars()
                ->countries()
                ->pluck('id');
        }

        if ($destination->vars()->isCountry()) {
            $areas = [$destination->id];
            if ($destination->vars()->facts()->lat) {
                $smalldots = [
                    [
                        'lat' => snap($destination->vars()->facts()->lat),
                        'lon' => snap($destination->vars()->facts()->lon)
                    ]
                ];
            }
        }

        if ($destination->vars()->isCity()) {
            $areas = [$destination->vars()->country()->id];
            if ($destination->vars()->facts()->lat) {
                $smalldots = [
                    [
                        'lat' => snap($destination->vars()->facts()->lat),
                        'lon' => snap($destination->vars()->facts()->lon)
                    ]
                ];
                $largedots = [$destination->vars()->facts()];
            }
        }

        if ($destination->vars()->isPlace()) {
            $areas = [$destination->vars()->country()->id];
            if ($destination->vars()->facts()->lat) {
                $smalldots = [
                    [
                        'lat' => snap($destination->vars()->facts()->lat),
                        'lon' => snap($destination->vars()->facts()->lon)
                    ]
                ];
                $largedots = [$destination->vars()->facts()];
            }
        }

        return component('Dotmap')
            ->with('height', '300px')
            ->with('areas', $areas)
            ->with('smalldots', $smalldots)
            ->with('mediumdots', $largedots)
            ->with('mediumdotcolor', 'red');
    }
}
