<?php

namespace App\Http\Regions;

class DestinationBar
{
    public function render($destination, $parents, $is = '')
    {
        return component('DestinationBar')
            ->is($is)
            ->with('title', $destination->vars()->name)
            ->with('route', route('v2.destination.show', [$destination]))
            ->with('parents', $parents
                ->map(function ($parent) {
                    return component('MetaLink')
                        ->is('white')
                        ->with('title', $parent->vars()->name . ' › ')
                        ->with('route', route('v2.destination.show', [$parent]));
                })
                ->render()
                ->implode('')
            );
    }
}
