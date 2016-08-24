<?php

namespace App\Http\Regions;

class ProfileMasthead
{
    public function render($user)
    {
        return component('ProfileMasthead')
            ->with('map', component('Map'))
            ->with('header', component('Header')
                ->with('search', component('HeaderSearch')->is('white'))
                ->with('logo', component('Icon')
                    ->with('icon', 'tripee_logo_plain_dark')
                    ->with('width', 80)
                    ->with('height', 30)
                )
                ->with('navbar', region('Navbar', 'white'))
                ->with('navbar_mobile', region('NavbarMobile', 'white'))
            )
            ->with('profile', component('ProfileImage')
                ->is('dark')
                ->with('route', route('user.show', [$user]))
                ->with('image', $user->imagePreset('small_square'))
                ->with('rank', $user->vars()->rank)
                ->with('size', 192)
                ->with('border', 10)
            )
            ->with('name', $user->vars()->name)
            ->with('meta', 'Kasutaja annela on Tripi liige 10 aastat');
    }
}
