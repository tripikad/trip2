<?php

namespace App\Http\Regions;

class FrontpageBottom
{
    public function render($flights, $travelmates)
    {
        return component('GridSplit')
            ->with('left_col', 8)
            ->with('right_col', 4)
            ->with('left_content', collect()
                ->push(component('Block')
                    ->with('title', trans('frontpage.index.flight.title'))
                    ->with('route', route('flight.index'))
                    ->with('content', $flights->map(function ($flight) {
                        return region('FlightRow', $flight);
                    }))
                )
            )
            ->with('right_content', collect()
                ->push(component('Block')
                    ->with('title', trans('frontpage.index.travelmate.title'))
                    ->with('route', route('travelmate.index'))
                    ->with('content', $travelmates->map(function ($travelmate) {
                        return region('TravelmateCard', $travelmate);
                    }))
                )
            );
    }
}
