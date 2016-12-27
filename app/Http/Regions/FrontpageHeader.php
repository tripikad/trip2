<?php

namespace App\Http\Regions;

use App\Image;

class FrontpageHeader
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
                    ->with('icon', 'tripee_logo')
                    ->with('width', 200)
                    ->with('height', 150)
                )
                ->with('navbar_desktop', region('NavbarDesktop', 'white'))
                ->with('navbar_mobile', region('NavbarMobile', 'white'))
            )
            ->with('title', $title);
    }
}
