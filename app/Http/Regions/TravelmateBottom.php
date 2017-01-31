<?php

namespace App\Http\Regions;

class TravelmateBottom
{
    public function render($flights, $forums, $news)
    {
        return component('Grid3')
            ->with('gutter', true)
            ->with('items', collect()
                ->push(component('Block')
                    ->with('title', trans('frontpage.index.flight.title'))
                    ->with('route', route('flight.index'))
                    ->with('content', $flights->map(function ($flight) {
                        return region('FlightRow', $flight);
                    }))
                )
                ->push(component('Block')
                    ->with('title', trans('frontpage.index.forum.title'))
                    ->with('route', route('forum.index'))
                    ->with('content', $forums->map(function ($forum) {
                        return region('ForumRow', $forum);
                    }))
                )
                ->push(component('Block')
                    ->with('title', trans('frontpage.index.news.title'))
                    ->with('route', route('news.index'))
                    ->with('content', $news->map(function ($new) {
                        return region('NewsCard', $new);
                    }))
                )
            );
    }
}
