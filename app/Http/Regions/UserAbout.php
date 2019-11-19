<?php

namespace App\Http\Regions;

class UserAbout
{
    public function render($user)
    {
        return component('Title')
            ->is('white')
            ->is('small')
            ->with(
                'title',
                collect()
                    ->push(trans("user.rank.$user->rank"))
                    ->pushWhen(
                        $user->hasRole('admin') || $user->hasRole('superuser'),
                        trans('user.show.about.admin')
                    )
                    ->push(
                        trans('user.show.about.joined', [
                            'created_at' => $user->vars()->created_at_relative
                        ])
                    )

                    ->implode('')
            );
    }
}
