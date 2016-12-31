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
