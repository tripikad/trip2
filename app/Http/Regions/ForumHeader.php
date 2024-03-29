<?php

namespace App\Http\Regions;

class ForumHeader
{
    public function render($content = [])
    {
        return component('HeaderLight')
            ->with('content', $content)
            ->with(
                'navbar',
                component('Navbar')
                    ->with('search', component('NavbarSearch'))
                    ->with(
                        'logo',
                        component('Icon')
                            ->with('icon', 'trip-ukraine-dark')
                            ->with('width', 200)
                            ->with('height', 150)
                    )
                    ->with('navbar_desktop', region('NavbarDesktop'))
                    ->with('navbar_mobile', region('NavbarMobile'))
            );
    }
}
