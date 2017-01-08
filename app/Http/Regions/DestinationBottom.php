<?php

namespace App\Http\Regions;

class DestinationBottom
{
    public function render($flights, $travelmates, $news)
    {
        return component('Grid3')
            ->with('gutter', true)
            ->with('items', collect()
                ->push(component('Block')
                    ->with('title', trans('frontpage.index.flight.title'))
                    ->with('route', route('v2.flight.index'))
                    ->with('content', $flights->map(function ($flight) {
                        return region('FlightRow', $flight);
                    }))
                )
                ->push(component('Block')
                    ->with('title', trans('frontpage.index.travelmate.title'))
                    ->with('route', route('v2.travelmate.index'))
                    ->with('content', $travelmates->map(function ($travelmate) {
                        return region('TravelmateCard', $travelmate);
                    }))
                )
                ->push(component('Block')
                    ->with('title', trans('frontpage.index.news.title'))
                    ->with('route', route('v2.news.index'))
                    ->with('content', $news->map(function ($new) {
                        return region('NewsCard', $new);
                    }))
                )
            );
    }
}
