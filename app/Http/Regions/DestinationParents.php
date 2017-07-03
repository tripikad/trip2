<?php

namespace App\Http\Regions;

class DestinationParents
{
    public function render($parents, $short = false)
    {
        return component('Meta')
            ->with('items', $parents->map(function ($parent) use ($short) {
                $title = $short ? $parent->vars()->shortName : $parent->vars()->name;
                return component('MetaLink')
                    ->is('large')
                    ->is('white')
                    ->with('title', $title.' › ')
                    ->with('route', route('destination.show', [$parent]));
            }));
    }
}
