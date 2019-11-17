<?php

namespace App\Http\Regions;

class DestinationMap
{
    public function render($destination)
    {
        $areas = [];
        $mediumdots = [];
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
            $largedots = [$destination->id];
        }

        if ($destination->vars()->isPlace()) {
            $areas = [$destination->vars()->country()->id];
            $largedots = [$destination->id];
        }

        return component('Dotmap')
            ->with('height', '300px')
            ->with('destination_dots', config('destination_dots'))
            ->with('destination_facts', config('destination_facts'))
            ->with('areas', $areas)
            ->with('largedots', $largedots);
    }
}
