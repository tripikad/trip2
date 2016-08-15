<?php

namespace App\Http\Regions;

class FlightRow
{
    public function render($post)
    {
        return component('FlightRow')
            ->with('route', route('content.show', [$post->type, $post]))
            ->with('icon', component('Icon')
                ->is('blue')
                ->with('icon', 'icon-tickets')
                ->with('size', 'xl')
            )
            ->with('title', $post->title)
            ->with('meta', component('Meta')->with('items', collect()
                    ->push(component('Link')
                        ->with('title', $post->vars()->created_at)
                    )
                    ->merge($post->destinations->map(function ($tag) {
                        return component('Tag')->is('orange')->with('title', $tag->name);
                    }))
                    ->merge($post->topics->map(function ($tag) {
                        return component('Tag')->with('title', $tag->name);
                    }))
                )
            );
    }
}
