<?php

namespace App\Http\Regions;

class UserHeaderImage
{
    public function render($user, $loggedUser)
    {
        return component('UserHeaderImage')
            ->with('user', component('UserImage')
                ->with('route', route('user.show', [$user]))
                ->with('image', $user->imagePreset('small_square'))
                ->with('rank', $user->vars()->rank)
                ->with('size', 152)
                ->with('border', 7)
            )
            ->with('title', component('Title')
                ->is('white')
                ->is('large')
                ->with('title', $user->vars()->name)
            )
            ->with('actions', component('BlockHorizontal')
                ->with('content', collect()
                    ->pushWhen(
                        $loggedUser
                        && $loggedUser->hasRole('regular')
                        && $loggedUser->id != $user->id,
                        component('Button')
                            ->is('cyan')
                            ->with('title', trans('user.show.message.create'))
                            ->with('route', route(
                                'message.index.with',
                                [$loggedUser, $user]
                            )
                        )
                    )
                )
            );
    }
}
