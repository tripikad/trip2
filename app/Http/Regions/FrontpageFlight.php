<?php

namespace App\Http\Regions;

class FrontpageFlight
{

    public function render($flights)
    {

        return component('Grid3')->with('items', $flights
            ->map(function ($flight, $key) {
                $destination = $flight->destinations->first();

                return region(
                        'DestinationBar',
                        $destination,
                        $destination->getAncestors(),
                        ['', 'dark', ''][$key]
                    )
                    .region('FlightCard', $flight);
            })
        );
    }

}
