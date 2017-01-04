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
                ->with('route', route('user.show', [$user]))
                ->with('image', $user->imagePreset('small_square'))
                ->with('rank', $user->vars()->rank)
                ->with('size', 132)
                ->with('border', 7)
            )
            ->with('name', $user->vars()->name)
            // ->with('wantstogo', trans('user.show.wantstogo.title'))
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
                    ->push(component('StatCard')
                        ->with('icon', 'icon-thumb-up')
                        ->with('title', $user->likes()->count())
                    )
                    ->push(component('StatCard')
                        ->with('title', $user->vars()->contentCount.' / '.$user->vars()->commentCount)
                        ->with('icon', 'icon-comment')
                    )
                    ->push(component('StatCard')
                        ->with('title', $user->vars()->destinationCount()
                            .' ( '.$user->vars()->destinationCountPercentage().'% )'
                        )
                        ->with('icon', 'icon-pin')
                    )
                )
            )
            ->with('actions_by_user', component('BlockHorizontal')
                ->with('content', $this->prepareActionsForUser($user, $loggedUser))
            );
    }
}
