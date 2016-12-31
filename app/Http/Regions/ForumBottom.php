<?php

namespace App\Http\Regions;

class ForumBottom
{
    public function render($flights, $travelmates, $news)
    {
        return component('Grid3')
            ->with('gutter', true)
            ->with('items', collect()
                ->push(component('Block')
                    ->is('uppercase')
                    ->is('white')
                    ->with('title', trans('frontpage.index.flight.title'))
                    ->with('content', $flights->map(function ($flight) {
                        return region('FlightRow', $flight);
                    }))
                )
                ->push(component('Block')
                    ->is('uppercase')
                    ->is('white')
                    ->with('title', trans('frontpage.index.travelmate.title'))
                    ->with('content', $travelmates->map(function ($travelmate) {
                        return region('TravelmateCard', $travelmate);
                    }))
                )
                ->push(component('Block')
                    ->is('uppercase')
                    ->is('white')
                    ->with('title', trans('frontpage.index.news.title'))
                    ->with('content', $news->map(function ($new) {
                        return region('NewsCard', $new);
                    }))
                )
            );
    }
}
