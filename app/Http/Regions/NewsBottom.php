<?php

namespace App\Http\Regions;

class NewsBottom
{
    public function render($flights, $forums, $travelmates)
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
                    ->with('title', trans('frontpage.index.forum.title'))
                    ->with('content', $forums->map(function ($forum) {
                        return region('ForumRow', $forum);
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
            );
    }
}
