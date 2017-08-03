<?php

namespace App\Http\Regions;

class DestinationBar
{
    public function render($destination, $is = '')
    {
        $destinations = $destination
            ->getAncestors()
            ->onlyLast(2);

        $parentLength = mb_strlen($destinations
            ->map(function ($parent) {
                return $parent->vars()->name;
            })
            ->implode('')
        );

        if ($parentLength > 25) {
            $destinations = $destinations->take(1);
        }

        return component('DestinationBar')
            ->is($is)
            ->with('title', $destination->vars()->shortName)
            ->with('route', route('destination.showSlug', [$destination->slug]))
            ->with('parents', region(
                    'DestinationParents',
                    $destinations,
                    $short = true
                )
            );
    }
}
