<?php

namespace App\Http\Regions;

class FlightCard
{
    public function render($post)
    {
        return component('FlightCard')
            ->with('route', route('v2.flight.show', [$post->slug]))
            ->with('background', $post->imagePreset('large'))
            ->with('title', $post->vars()->title);
    }
}
