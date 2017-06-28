<?php

namespace App\Http\Regions;

class FrontpageHeader
{
    public function render($destinations)
    {   
        return component('FrontpageHeader')
            ->with('background', '/photos/header3.jpg')
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
            ->with('search', component('FrontpageDestinationSearch')
                ->with('route', route('destination.show', [0]))
                ->with('placeholder', trans('frontpage.index.search.title'))
                ->with('options', $destinations)
            );
    }
}
