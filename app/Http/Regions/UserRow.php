<?php

namespace App\Http\Regions;

class UserRow
{
    public function render($user)
    {
        return component('Flex')
            ->with('gap', 1)
            ->with('align', 'center')
            ->with(
                'items',
                collect()
                    ->push(
                        component('UserImage')
                            ->with('route', route('user.show', [$user]))
                            ->with('image', $user ? $user->imagePreset('small_square') : '')
                            ->with('rank', $user ? $user->vars()->rank : '')
                    )
                    ->push(
                        component('Title')
                            ->is('white')
                            ->is('smallest')
                            ->with('title', $user ? $user->name : '')
                    )
            );
    }
}
