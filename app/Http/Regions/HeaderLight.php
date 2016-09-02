<?php

namespace App\Http\Regions;

class HeaderLight
{
    public function render($title = '')
    {
        $background = '/photos/map.svg';

        return component('HeaderLight')
            ->with('background', $background)
            ->with('title', $title)
            ->with('navbar', component('Navbar')
                ->with('search', component('NavbarSearch'))
                ->with('logo', component('Icon')
                    ->with('icon', 'tripee_logo_plain_dark')
                    ->with('width', 80)
                    ->with('height', 30)
                )
                ->with('navbar_desktop', region('NavbarDesktop'))
                ->with('navbar_mobile', region('NavbarMobile'))
            )
        ;
    }
}
