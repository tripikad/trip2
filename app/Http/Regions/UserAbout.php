<?php

namespace App\Http\Regions;

class UserAbout
{

    public function render($user)
    {

        return component('Body')
            ->is('cyan')
            ->is('responsive')
            ->with('body', collect()
                ->push(trans("user.rank.$user->rank"))
                ->pushWhen(
                    $user->hasRole('admin') || $user->hasRole('superuser'),
                    trans('user.show.about.admin')
                )
                ->push(
                    trans('user.show.about.joined', [
                        'created_at' => $user->vars()->created_at_relative,
                    ])
                )
                ->pushWhen(
                    $user->vars()->destinationWantsToGo()->count(),
                    trans('user.show.about.wanttogo')
                )
                ->implode('')
        );

    }

}
