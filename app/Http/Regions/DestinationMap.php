<?php

namespace App\Http\Regions;

class DestinationMap
{
    public function render($destination)
    {
        $areas = [];
        $largedots = [];

        if ($destination->vars()->isContinent()) {
            $areas = $destination
                ->vars()
                ->countries()
                ->pluck('id');
        }

        if ($destination->vars()->isCountry()) {
            $areas = [$destination->id];
        }

        if ($destination->vars()->isCity()) {
            $areas = [$destination->vars()->country()->id];
            $largedots = [$destination->vars()->facts()];
        }

        if ($destination->vars()->isPlace()) {
            $areas = [$destination->vars()->country()->id];
            $largedots = [$destination->vars()->facts()];
        }

        return component('Dotmap')
            ->with('height', '300px')
            ->with('countrydots', config('countrydots'))
            ->with('areas', $areas)
            ->with('largedots', $largedots)
            ->with('largedotcolor', 'red');
    }
}
