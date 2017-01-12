<?php

namespace App\Http\Regions;

class UserStats
{
    public function render($user, $loggedUser)
    {
        return component('BlockHorizontal')
            ->with('content', collect()
                ->push(component('StatCard')
                    ->with('icon', 'icon-thumb-up')
                    ->with('title', trans(
                        'user.show.stat.likes', [
                            'likes_count' => $user->vars()->flagCount('good'),
                        ]
                    ))
                )
                ->pushWhen(
                    $loggedUser && $loggedUser->hasRole('admin'),
                    component('StatCard')
                        ->with('icon', 'icon-thumb-down')
                        ->with('title', trans(
                            'user.show.stat.dislikes', [
                                'dislikes_count' => $user->vars()->flagCount('bad'),
                            ]
                        ))
                )
                ->push(component('StatCard')
                    ->with('title', trans(
                        'user.show.stat.content', [
                            'content_count' => $user->vars()->contentCount,
                            'comment_count' => $user->vars()->commentCount,
                        ]
                    ))
                    ->with('icon', 'icon-comment')
                )
                ->push(component('StatCard')
                    ->with('title', trans(
                        'user.show.stat.destination', [
                            'destination_count' => $user->vars()->destinationCount(),
                            'destination_percentage' => $user->vars()->destinationCountPercentage(),
                        ]
                    ))
                    ->with('icon', 'icon-pin')
                )
            );
    }
}
