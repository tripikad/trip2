<?php

namespace App\Http\Regions;

class FlightRow
{
    public function render($flight)
    {
        return component('FlightRow')
            ->with('route', route('flight.show', [$flight]))
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
                    ->push(component('MetaLink')
                        ->with('title', trans('comment.action.edit.title') + ' v2')
                        ->with('route', route('flight.edit.v2', [$flight]))
                    )
                    ->merge($flight->destinations->map(function ($tag) {
                        return component('Tag')->is('orange')->with('title', $tag->name);
                    }))
                    ->merge($flight->topics->map(function ($tag) {
                        return component('Tag')->with('title', $tag->name);
                    }))
                )
            );
    }
}
