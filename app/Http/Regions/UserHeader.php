<?php

namespace App\Http\Regions;

class UserHeader
{
    private function prepareActionsForUser($user, $loggedUser)
    {
        return collect()
            ->pushWhen(
                // Only owner sees the link, others can access it anyway and button is unneccesary
                $loggedUser && $loggedUser->id == $user->id,
                component('Button')
                    ->is('cyan')
                    ->with('title', trans('menu.user.activity'))
                    ->with('route', route('v2.user.show', [$user]))
            )
            ->pushWhen(
                $loggedUser && $loggedUser->hasRoleOrOwner('superuser', $loggedUser->id),
                component('Button')
                    ->is('cyan')
                    ->with('title', trans('menu.user.edit.profile'))
                    ->with('route', route('user.edit', [$user]))
            )
            ->pushWhen(
                // Only the owner can see its own messages
                $loggedUser && $loggedUser->id == $user->id,
                component('Button')
                    ->is('cyan')
                    ->with('title', trans('menu.user.message'))
                    ->with('route', route('v2.message.index', [$user]))
            )
            ->pushWhen(
                $loggedUser && $loggedUser->hasRoleOrOwner('superuser', $loggedUser->id),
                component('Button')
                    ->is('cyan')
                    ->with('title', trans('menu.user.add.places'))
                    ->with('route', route('user.destinations', [$user]))
            );
    }

    public function render($user)
    {
        $loggedUser = request()->user();

        return component('UserHeader')
            ->with('background', component('MapBackground'))
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
            ->with('user', component('UserImage')
                ->with('route', route('v2.user.show', [$user]))
                ->with('image', $user->imagePreset('small_square'))
                ->with('rank', $user->vars()->rank)
                ->with('size', 152)
                ->with('border', 7)
            )
            ->with('name', $user->vars()->name)
            ->with('actions_with_user', component('BlockHorizontal')
                ->with('content', collect()
                    ->pushWhen(
                        $loggedUser && $loggedUser->hasRole('regular') && $loggedUser->id != $user->id,
                        component('Button')
                            ->is('cyan')
                            ->with('title', trans('user.show.message.create'))
                    )
                )
            )
            ->with('meta', collect()
                ->pushWhen(
                    $user->vars()->description,
                    $user->vars()->description.'. '
                )
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
            )
            ->with('wanttogo', $user
                ->vars()
                ->destinationWantsToGo()
                ->map(function ($destination) {
                    return component('Tag')
                        ->is('white')
                        ->is('large')
                        ->with('title', $destination->flaggable->name)
                        ->with('route', route(
                            'v2.destination.show',
                            [$destination->flaggable]
                        ));
                })
                ->render()
                ->implode(' ')
            )
            ->with('stats', component('BlockHorizontal')
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
                )
            )
            ->with('actions_by_user', component('BlockHorizontal')
                ->with('content', $this->prepareActionsForUser($user, $loggedUser))
            );
    }
}
