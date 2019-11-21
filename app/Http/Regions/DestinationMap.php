<?php

namespace App\Http\Regions;

class DestinationMap
{
    public function render($destination)
    {
        $areas = [];
        $largedots = [];
        $smalldots = [];

        if ($destination->isContinent()) {
            $areas = $destination
                ->vars()
                ->countries()
                ->pluck('id');
        }

        if ($destination->isCountry()) {
            $areas = [$destination->id];
            if ($coordinates = $destination->vars()->snappedCoordinates()) {
                $smalldots = [$coordinates];
            }
        }

        if ($destination->isCity()) {
            $areas = [$destination->vars()->country()->id];
            if ($coordinates = $destination->vars()->snappedCoordinates()) {
                $smalldots = [$coordinates];
                $largedots = [$destination->vars()->coordinates()];
            }
        }

        if ($destination->isPlace()) {
            $areas = [$destination->vars()->country()->id];
            if ($coordinates = $destination->vars()->snappedCoordinates()) {
                $smalldots = [$coordinates];
                $largedots = [$destination->vars()->coordinates()];
            }
        }

        return component('Dotmap')
            ->with('height', '300px')
            ->with('areas', $areas)
            ->with('smalldots', $smalldots)
            ->with('largedots', $largedots)
            ->with('largedotcolor', 'red');
    }
}
