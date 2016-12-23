<?php

namespace App\Http\Regions;

class UserHeader
{
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
                ->with('route', route('user.show', [$user]))
                ->with('image', $user->imagePreset('small_square'))
                ->with('rank', $user->vars()->rank)
                ->with('size', 132)
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
            ->with('meta', trans('user.show.joined', [
                'user' => $user->name,
                'created_at' => $user->vars()->created_at_relative,
            ]))
            ->with('stats', component('BlockHorizontal')
                ->with('content', collect()
                    ->push(component('UserStat')
                        ->with('icon', 'icon-thumb-up')
                        ->with('title', '26')
                    )
                    ->push(component('UserStat')
                        ->with('title', '134 / 40')
                        ->with('icon', 'icon-comment')
                    )
                    ->push(component('UserStat')
                        ->with('title', '12 (1.91%)')
                        ->with('icon', 'icon-pin')
                    )
                )
            )
            ->with('actions_by_user', component('BlockHorizontal')
                ->with('content', collect()
                    ->pushWhen(
                        $loggedUser && $loggedUser->hasRoleOrOwner('superuser', $loggedUser->id),
                        component('Button')
                            ->is('cyan')
                            ->with('title', trans('menu.user.edit.profile'))
                    )
                    ->pushWhen(
                        $loggedUser && $loggedUser->id == $user->id, // Only the owner can see own messages
                        component('Button')
                            ->is('cyan')
                            ->with('title', trans('menu.user.message'))
                    )
                    ->pushWhen(
                        $loggedUser && $loggedUser->hasRoleOrOwner('superuser', $loggedUser->id),
                        component('Button')
                        ->is('cyan')
                        ->with('title', trans('menu.user.follow'))
                    )
                    ->pushWhen(
                        $loggedUser && $loggedUser->hasRoleOrOwner('superuser', $loggedUser->id),
                        component('Button')
                        ->is('cyan')
                        ->with('title', trans('menu.user.add.places'))
                    )
                )
            );
    }
}
