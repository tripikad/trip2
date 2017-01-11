<?php

namespace App\Http\Regions;

class FlightRow
{
    public function render($flight)
    {
        return component('FlightRow')
            ->with('route', route('v2.flight.show', [$flight->slug]))
            ->with('icon', component('Icon')
                ->is('blue')
                ->with('icon', 'icon-tickets')
                ->with('size', 'xl')
            )
            ->with('title', $flight->title)
            ->with('meta', component('Meta')->with('items', collect()
                    ->push(component('MetaLink')
                        ->with('title', $flight->vars()->created_at)
                    )
                    ->push(component('MetaLink')
                        ->with('title', trans('comment.action.edit.title'))
                        ->with('route', route('content.edit', [$flight->type, $flight]))
                    )
                    ->merge($flight->destinations->map(function ($destination) {
                        return component('Tag')
                            ->is('orange')
                            ->with('title', $destination->name)
                            ->with('route', route('v2.destination.show', [$destination]));
                    }))
                    ->merge($flight->topics->map(function ($tag) {
                        return component('Tag')->with('title', $tag->name);
                    }))
                )
            );
    }
}
