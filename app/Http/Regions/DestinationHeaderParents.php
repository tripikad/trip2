<?php

namespace App\Http\Regions;

class DestinationHeaderParents
{
    public function render($parents)
    {
        return component('Meta')->with(
            'items',
            collect()
                ->push(
                    component('Tag')
                        ->is('large')
                        ->is('white')
                        ->with('title', '‹ &nbsp; Sihtkohad')
                        ->with('route', route('destination.index'))
                )
                ->merge(
                    $parents->map(function ($parent) {
                        $title = $parent->vars()->name;

                        return component('Tag')
                            ->is('large')
                            ->is('white')
                            ->with('title', ' ‹ &nbsp;' . $title)
                            ->with('route', route('destination.showSlug', [$parent->slug]));
                    })
                )
        );
    }
}
