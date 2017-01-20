<?php

namespace App\Http\Regions;

class FrontpageFlight
{
    public function render($flights)
    {
        return component('Grid3')->with('items', $flights
            ->map(function ($flight, $index) {
                $destination = $flight->destinations->first();
                return region(
                        'DestinationBar',
                        $destination,
                        ['purple', 'yellow', 'red'][$index]
                    )
                    .region('FlightCard', $flight);
            })
        );
    }
}
