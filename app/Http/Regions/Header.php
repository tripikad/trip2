<?php

namespace App\Http\Regions;

use App\Image;

class Header
{
    public function render($title = false)
    {
        $background = 'http://68.media.tumblr.com/9c7c25deb2d0c7c4e59928de300ca20e/tumblr_nx5c7cX0L01ta0hnbo1_1280.jpg';

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
            ->with('title', $title);
    }
}
