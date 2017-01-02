<?php

namespace App\Http\Regions;

class DestinationHeader
{
    public function render($destination)
    {
        $parents = $destination->getAncestors();

        $facts = $destination->vars()->facts
            ? $destination->vars()->facts
                ->flip()
                ->map(function($value, $key) {
                    return trans("destination.show.about.$value");
                })
                ->flip()
            : null;

        return component('DestinationHeader')
            ->with('background', component('MapBackground'))
            ->with('navbar', component('Navbar')
                ->is('white')
                ->with('search', component('NavbarSearch')->is('white'))
                ->with('logo', component('Icon')
                    ->with('icon', 'tripee_logo')
                    ->with('width', 200)
                    ->with('height', 150)
                )
                ->with('navbar_desktop', region('NavbarDesktop', 'white'))
                ->with('navbar_mobile', region('NavbarMobile', 'white'))
            )
            ->with('parents', $parents
                ->map(function ($parent) {
                    return component('MetaLink')
                        ->is('large')
                        ->is('white')
                        ->with('title', $parent->vars()->name.' › ')
                        ->with('route', route('v2.destination.show', [$parent]));
                })
                ->render()
                ->implode('')
            )
            ->with('title', $destination->name)
            ->with('description', $destination->vars()->description)
            ->with('facts', component('DestinationFacts')
                ->with('facts', $facts)
            )
            ->with('stats', component('BlockHorizontal')
                ->with('content', collect()
                    ->push(component('StatCard')
                        ->with('icon', 'icon-pin')
                        ->with('title', $destination->vars()->usersWantsToGo()->count())
                    )
                    ->push(component('StatCard')
                        ->with('title', $destination->vars()->usersHaveBeen()->count())
                        ->with('icon', 'icon-star')
                    )
                )
            );
    }
}
