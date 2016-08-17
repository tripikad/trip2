<?php

namespace App\Http\Regions;

class Masthead
{
    public function render($title = '')
    {
        return component('Masthead')
            ->with('header', component('Header')
                ->with('search', component('HeaderSearch')->is('gray'))
                ->with('logo', component('Icon')
                    ->with('icon', 'tripee_logo_plain_dark')
                    ->with('width', 80)
                    ->with('height', 30)
                )
                ->with('navbar', region('Navbar'))
                ->with('navbar_mobile', region('NavbarMobile'))
            )
            ->with('title', $title);
    }
}
