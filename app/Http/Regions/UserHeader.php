<?php

namespace App\Http\Regions;
use App\Destination;

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
        $countryCount = 195;

        $loggedUser = request()->user();
        $wantsToGo = $user->vars()->destinationWantsToGo();
        $hasBeenContinents = $user
            ->vars()
            ->destinationHaveBeen()
            ->filter(function ($f) {
                return $f->flaggable->vars()->isCity() ||
                    $f->flaggable->vars()->isPlace();
            });
        $hasBeenCountries = $user
            ->vars()
            ->destinationHaveBeen()
            ->filter(function ($f) {
                return $f->flaggable->vars()->isCountry();
            });
        $hasBeenCities = $user
            ->vars()
            ->destinationHaveBeen()
            ->filter(function ($f) {
                return $f->flaggable->vars()->isCity() ||
                    $f->flaggable->vars()->isPlace();
            });

        $countryDots = $hasBeenCountries
            ->map(function ($f) {
                return $f->flaggable->id;
            })
            ->values();

        $cityDots = $hasBeenCities
            ->map(function ($f) {
                return $f->flaggable->vars()->facts();
            })
            ->filter(function ($f) {
                return $f;
            })
            ->map(function ($d) {
                return [
                    'lat' => snap($d->lat),
                    'lon' => snap($d->lon)
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
                        component('Center')->with(
                            'item',
                            region('UserAbout', $user, $loggedUser)
                        )
                    )
                    ->push(region('UserStats', $user, $loggedUser))
                    ->br()
                    ->push(
                        component('Body')
                            ->is('white')
                            ->is('responsive')
                            ->with('body', $user->vars()->description)
                    )
                    ->br()
                    ->pushWhen(
                        $wantsToGo->count(),
                        component('Flex')
                            ->with('align', 'center')
                            ->with('gap', 1)
                            ->with(
                                'items',
                                collect()
                                    ->push(
                                        component('Icon')
                                            ->is('white')
                                            ->with('size', 'xl')
                                            ->with('icon', 'icon-pin')
                                    )
                                    ->push(
                                        component('Title')
                                            ->is('white')
                                            ->with(
                                                'title',
                                                trans(
                                                    'user.show.stat.destination',
                                                    [
                                                        'country_total_count' => $countryCount,
                                                        'country_count' => $hasBeenCountries->count(),
                                                        'percentage' => round(
                                                            ($hasBeenCountries->count() /
                                                                $countryCount) *
                                                                100
                                                        )
                                                    ]
                                                )
                                            )
                                    )
                            )
                    )
                    // ->push(
                    //     component('Title')
                    //         ->is('b')
                    //         ->with(
                    //             'title',
                    //             trans('user.show.stat.destination', [
                    //                 'destination_count' => $user
                    //                     ->vars()
                    //                     ->destinationCount(),
                    //                 'destination_percentage' => $user
                    //                     ->vars()
                    //                     ->destinationCountPercentage()
                    //             ]) . ':'
                    //         )
                    //         ->with('icon', 'icon-pin')
                    // )
                    ->pushWhen(
                        $hasBeenCountries->count(),
                        component('Flex')
                            ->is('wrap')
                            ->is('large')
                            ->with('gap', 0.5)
                            ->with(
                                'items',
                                $hasBeenCountries->map(function ($destination) {
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
                    ->pushWhen(
                        $wantsToGo->count(),
                        component('Flex')
                            ->with('align', 'center')
                            ->with('gap', 1)
                            ->with(
                                'items',
                                collect()
                                    ->push(
                                        component('Icon')
                                            ->is('white')
                                            ->with('size', 'xl')
                                            ->with('icon', 'icon-star')
                                    )
                                    ->push(
                                        component('Title')
                                            ->is('white')
                                            ->is('small')
                                            ->with('title', 'Tahab minna')
                                    )
                            )
                    )
                    ->pushWhen(
                        $wantsToGo->count(),
                        component('Flex')
                            ->is('large')
                            ->is('wrap')
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
                    ->push(
                        component('BlockHorizontal')->with(
                            'content',
                            $this->prepareActionsForUser($user, $loggedUser)
                        )
                    )
            );
    }
}
