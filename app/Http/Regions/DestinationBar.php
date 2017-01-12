<?php

namespace App\Http\Regions;

class DestinationBar
{
    public function render($destination, $is = '')
    {
        $parentLength = mb_strlen($destination
            ->getAncestors()
            ->onlyLast(2)
            ->map(function ($parent) {
                return $parent->vars()->name;
            })
            ->implode('')
        );

        return component('DestinationBar')
            ->is($is)
            ->with('title', $destination->vars()->shortName)
            ->with('route', route('v2.destination.show', [$destination]))
            ->with('parents', region(
                'DestinationParents',
                $destination->getAncestors()->onlyLast($parentLength > 30 ? 1 : 2),
                $short = true
            )
        );
    }
}
