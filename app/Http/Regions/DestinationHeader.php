<?php

namespace App\Http\Regions;

class DestinationHeader
{
    public function render($destination)
    {
        return component('DestinationHeader')
            ->with('map', component('Map'))
            ->with('header', component('Navbar')
                ->with('search', component('NavbarSearch')->is('white'))
                ->with('logo', component('Icon')
                    ->with('icon', 'tripee_logo_plain_dark')
                    ->with('width', 80)
                    ->with('height', 30)
                )
                ->with('navbar_desktop', region('NavbarDesktop', 'white'))
                ->with('navbar_mobile', region('NavbarMobile', 'white'))
            )
            ->with('name', $destination->name)
            ->with('meta', trans("destination.show.description.$destination->id"));
    }
}
