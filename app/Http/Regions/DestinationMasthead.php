<?php

namespace App\Http\Regions;

class DestinationMasthead
{
    public function render($destination)
    {
        return component('DestinationMasthead')
            ->with('map', component('Map'))
            ->with('header', component('Header')
                ->with('search', component('HeaderSearch')->is('white'))
                ->with('logo', component('Icon')
                    ->with('icon', 'tripee_logo_plain_dark')
                    ->with('width', 80)
                    ->with('height', 30)
                )
                ->with('navbar', region('Navbar', 'white'))
                ->with('navbar_mobile', region('NavbarMobile', 'white'))
            )
            ->with('name', $destination->name)
            ->with('meta', trans("destination.show.description.$destination->id"));
    }
}
