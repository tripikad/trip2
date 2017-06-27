<?php

namespace App\Http\Regions;

class DestinationParents
{
    public function render($parents, $short = false)
    {
        $loopCount = 0;
        $parentsCount = $parents->count();

        return component('Meta')
            ->with('items', $parents->map(function ($parent) use ($short, &$loopCount, $parentsCount) {
                ++$loopCount;
                $title = $short ? $parent->vars()->shortName : $parent->vars()->name;
                
                return component('MetaLink')
                    ->is('large')
                    ->is('white')
                    ->with('title', $title . ($loopCount != $parentsCount ? ' › ' : ''))
                    ->with('route', route('destination.show', [$parent]));
            }));
    }
}
