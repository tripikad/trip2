<?php

namespace App\Http\Regions;

class FlightRow
{
    public function render($post)
    {
        return component('Meta')->with('items', collect()
            ->push(component('Link')
                ->with('title', $post->title)
            )
            ->push(component('Link')
                ->with('title', 'Edit')
                ->with('route', route('flight.edit', [$post]))
            )
        );
    }
}
