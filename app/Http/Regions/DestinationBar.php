<?php

namespace App\Http\Regions;

class DestinationBar
{
    public function render($destination, $parents)
    {
        return component('DestinationBar')
            ->with('title', $destination->vars()->name)
            ->with('route', route('destination.show.v2', [$destination]))
            ->with('subtitle', $parents
                ->map(function($parent) {
                    return (component('MetaLink')
                        ->is('white')
                        ->with('title', $parent->vars()->name)
                        ->with('route', route('destination.show.v2', [$parent]))
                    );
                })
                ->implode(' › ')
            );
    }
}