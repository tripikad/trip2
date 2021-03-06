<?php

namespace App\Http\Regions;

class FlightCard
{
    public function render($post)
    {
        return component('FlightCard')
            ->with('route', route('flight.show', [$post->slug]))
            ->with('background', $post->imagePreset('medium'))
            ->with('title', $post->vars()->title)
            ->with('shorttitle', $post->vars()->shortTitle);
    }
}
