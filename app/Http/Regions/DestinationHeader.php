<?php

namespace App\Http\Regions;

class DestinationHeader
{
    public function render($destination)
    {
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
            ->with('name', $destination->name)
            ->with('facts', region('DestinationFacts', $destination));
    }
}
