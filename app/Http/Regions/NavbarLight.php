<?php

namespace App\Http\Regions;

class NavbarLight
{
    public function render()
    {
        return component('Navbar')
            ->with('search', component('NavbarSearch'))
            ->with(
                'logo',
                component('Icon')
                    ->with('icon', 'tripee_logo')
                    ->with('width', 180)
                    ->with('height', 120)
            )
            ->with('navbar_desktop', region('NavbarDesktop', 'white'))
            ->with('navbar_mobile', region('NavbarMobile'));
    }
}
