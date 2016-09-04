<?php

namespace App\Http\Regions;

use App\Image;

class Header
{
    public function render($title = '', $background = '')
    {
        $background = $background ?? Image::getHeader();

        return component('Header')
            ->with('background', '/photos/header2.jpg')
            ->with('navbar', component('Navbar')
                ->is('white')
                ->with('search', component('NavbarSearch')->is('white'))
                ->with('logo', component('Icon')
                    ->with('icon', 'tripee_logo_plain_dark')
                    ->with('width', 80)
                    ->with('height', 30)
                )
                ->with('navbar_desktop', region('NavbarDesktop', 'white'))
                ->with('navbar_mobile', region('NavbarMobile', 'white'))
            )
            ->with('title', $title);
    }
}
