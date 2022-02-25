<?php

namespace App\Http\Regions;

class Header
{
    public function render($content = [], $background = '/photos/header3.jpg', $is = '')
    {
        return component('Header')
            ->is($is)
            ->with('background', $background)
            ->with(
                'navbar',
                component('Navbar')
                    ->is('white')
                    ->with('search', component('NavbarSearch')->is('white'))
                    ->with(
                        'logo',
                        component('Icon')
                            ->with('icon', 'trip-ukraine')
                            ->with('width', 200)
                            ->with('height', 125)
                    )
                    ->with('navbar_desktop', region('NavbarDesktop', 'white'))
                    ->with('navbar_mobile', region('NavbarMobile', 'white'))
            )
            ->with('content', $content);
    }
}
