<?php

namespace App\Http\Regions;

class Header
{
    public function render($content = null)
    {
        $background = '/photos/header3.jpg';

        return component('Header')
            ->with('background', $background)
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
            ->with('content', $content);
    }
}
