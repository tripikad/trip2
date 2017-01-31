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
                    ->with('route', route('user.show', [$user]))
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
                    ->with('route', route('message.index', [$user]))
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
        $wantsToGo = $user->vars()->destinationWantsToGo();

        return component('HeaderLight')
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
            ->with('content', collect()
                ->push(region('UserHeaderImage', $user, $loggedUser))
                ->push(component('Body')
                    ->is('white')
                    ->is('responsive')
                    ->with('body', $user->vars()->description)
                )
                ->push(region('UserAbout', $user, $loggedUser))
                ->pushWhen(
                    $wantsToGo->count(),
                    component('Meta')->is('large')->with('items', $wantsToGo
                        ->map(function ($destination) {
                            return component('Tag')
                                ->is('white')
                                ->is('large')
                                ->with('title', $destination->flaggable->name)
                                ->with('route', route(
                                    'destination.show',
                                    [$destination->flaggable]
                                ));
                        })
                ))
                ->push(region('UserStats', $user, $loggedUser))
                ->push(component('BlockHorizontal')->with(
                    'content',
                    $this->prepareActionsForUser($user, $loggedUser)
                ))
            );
    }
}
