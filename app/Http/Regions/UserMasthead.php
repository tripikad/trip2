<?php

namespace App\Http\Regions;

class UserMasthead
{
    public function render($user)
    {
        return component('UserMasthead')
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
            ->with('user', component('UserImage')
                ->is('dark')
                ->with('route', route('user.show', [$user]))
                ->with('image', $user->imagePreset('small_square'))
                ->with('rank', $user->vars()->rank)
                ->with('size', 168)
                ->with('border', 8)
            )
            ->with('name', $user->vars()->name)
            ->with('meta', trans('user.show.joined', [
                'user' => $user->name,
                'created_at' => $user->vars()->created_at_relative,
            ]));
    }
}
