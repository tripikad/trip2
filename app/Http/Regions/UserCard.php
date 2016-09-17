<?php

namespace App\Http\Regions;

class UserCard
{
    public function render($user)
    {
        return component('UserCard')
            ->with('image', component('UserImage')
                ->is('dark')
                ->with('route', route('v2.user.show', [$user]))
                ->with('image', $user->imagePreset('small_square'))
                ->with('rank', $user->vars()->rank)
                ->with('size', 56)
                ->with('border', 4)
            )
            ->with('name', $user->name)
            ->with('route', route('v2.user.show', [$user]))
            ->with('meta', 'Liitus '.$user->vars()->created_at_relative);
    }
}
