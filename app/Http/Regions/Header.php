<?php

namespace App\Http\Regions;

class Header
{
    public function render($title = '')
    {
        return component('Header')
            ->with('navbar', component('Navbar')
                ->with('search', component('NavbarSearch')->is('gray'))
                ->with('logo', component('Icon')
                    ->with('icon', 'tripee_logo_plain_dark')
                    ->with('width', 80)
                    ->with('height', 30)
                )
                ->with('navbar_desktop', region('NavbarDesktop'))
                ->with('navbar_mobile', region('NavbarMobile'))
            )
            ->with('title', $title);
    }
}
