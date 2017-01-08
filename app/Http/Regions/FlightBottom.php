<?php

namespace App\Http\Regions;

class FlightBottom
{
    public function render($forums, $travelmates, $news)
    {
        return component('Grid3')
            ->with('gutter', true)
            ->with('items', collect()
                ->push(component('Block')
                    ->with('title', trans('frontpage.index.forum.title'))
                    ->with('route', route('v2.forum.index'))
                    ->with('content', $forums->map(function ($forum) {
                            return region('ForumRow', $forum);
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
