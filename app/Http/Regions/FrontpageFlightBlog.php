<?php

namespace App\Http\Regions;

class FrontpageFlightBlog
{
    public function render($flights, $blogs)
    {
        return component('GridSplit')
            ->with('left_col', 8)
            ->with('right_col', 4)
            ->with('left_content', collect()
                ->push(component('Block')
                    ->is('white')
                    ->is('uppercase')
                    ->with('title', trans('frontpage.index.flight.title'))
                    ->with('content', $flights->take(3)->map(function ($bottomFlight) {
                        return region('FlightRow', $bottomFlight);
                    }))
                )
                ->push(component('Promo')->with('promo', 'body'))
                ->push(component('Block')
                    ->is('white')
                    ->with('content', $flights->slice(3)->map(function ($bottomFlight) {
                        return region('FlightRow', $bottomFlight);
                    }))
                )
            )
            ->with('right_content', collect()
                ->push(component('Block')
                    ->is('white')
                    ->is('uppercase')
                    ->with('title', trans('frontpage.index.blog.title'))
                    ->with('content', $blogs->map(function ($blog) {
                        return region('BlogCard', $blog);
                    }))
                )
            );
    }
}
