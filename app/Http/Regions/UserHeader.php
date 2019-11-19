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
                $loggedUser &&
                    $loggedUser->hasRoleOrOwner('superuser', $loggedUser->id),
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
                $loggedUser &&
                    $loggedUser->hasRoleOrOwner('superuser', $loggedUser->id),
                component('Button')
                    ->is('cyan')
                    ->with('title', trans('menu.user.add.places'))
                    ->with('route', route('user.destinations.edit', [$user]))
            );
    }

    public function render($user)
    {
        $loggedUser = request()->user();
        $wantsToGo = $user->vars()->destinationWantsToGo();
        $hasBeen = $user->vars()->destinationHaveBeen();

        $countryDots = $hasBeen
            ->map(function ($f) {
                return $f->flaggable->id;
            })
            ->values();

        $cityDots = $hasBeen
            ->filter(function ($f) {
                return $f->flaggable->vars()->isCity() ||
                    $f->flaggable->vars()->isPlace();
            })
            ->map(function ($f) {
                return $f->flaggable->vars()->facts();
            })
            ->map(function ($f) {
                return [
                    'lat' => snap($f->lat),
                    'lon' => snap($f->lon)
                ];
            })
            ->values();

        return component('HeaderLight')
            ->with(
                'navbar',
                component('Navbar')
                    ->is('white')
                    ->with('search', component('NavbarSearch')->is('white'))
                    ->with(
                        'logo',
                        component('Icon')
                            ->with('icon', 'tripee_logo')
                            ->with('width', 200)
                            ->with('height', 150)
                    )
                    ->with('navbar_desktop', region('NavbarDesktop', 'white'))
                    ->with('navbar_mobile', region('NavbarMobile', 'white'))
            )
            ->with(
                'content',
                collect()
                    ->push(
                        component('Dotmap')
                            ->with('height', '300px')
                            ->is('center')
                            ->with('areas', $countryDots)
                            ->with('smalldots', $cityDots)
                    )
                    ->push(region('UserHeaderImage', $user, $loggedUser))
                    ->push(
                        component('Body')
                            ->is('white')
                            ->is('responsive')
                            ->with('body', $user->vars()->description)
                    )
                    ->push(region('UserAbout', $user, $loggedUser))
                    ->pushWhen(
                        $wantsToGo->count(),
                        component('Meta')
                            ->is('large')
                            ->with(
                                'items',
                                $wantsToGo->map(function ($destination) {
                                    return component('Tag')
                                        ->is('white')
                                        ->is('large')
                                        ->with(
                                            'title',
                                            $destination->flaggable->name
                                        )
                                        ->with(
                                            'route',
                                            route('destination.showSlug', [
                                                $destination->flaggable->slug
                                            ])
                                        );
                                })
                            )
                    )
                    ->push(region('UserStats', $user, $loggedUser))
                    ->pushWhen(
                        $hasBeen->count(),
                        component('Flex')
                            ->is('wrap')
                            ->is('large')
                            ->with('gap', 0.5)
                            ->with(
                                'items',
                                $hasBeen->map(function ($destination) {
                                    return component('Tag')
                                        ->is('white')
                                        ->is('large')
                                        ->with(
                                            'title',
                                            $destination->flaggable->name
                                        )
                                        ->with(
                                            'route',
                                            route('destination.showSlug', [
                                                $destination->flaggable->slug
                                            ])
                                        );
                                })
                            )
                    )
                    ->push(
                        component('BlockHorizontal')->with(
                            'content',
                            $this->prepareActionsForUser($user, $loggedUser)
                        )
                    )
            );
    }
}
