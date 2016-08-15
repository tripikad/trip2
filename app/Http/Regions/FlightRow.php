<?php

namespace App\Http\Regions;

class FlightRow
{
    public function render($post)
    {
        return component('FlightRow')
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
                    ->push(component('Link')
                        ->with('title', trans('comment.action.edit.title'))
                        ->with('route', route('flight.edit', [$post]))
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
