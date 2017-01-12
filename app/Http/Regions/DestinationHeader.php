<?php

namespace App\Http\Regions;

class DestinationHeader
{
    public function render($destination)
    {
        $parents = $destination->getAncestors();

        return component('HeaderLight')
            ->with('background', component('BackgroundMap')->is('yellow'))
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
                ->push(component('Meta')
                    ->with('items', $parents->map(function ($parent) {
                        return component('MetaLink')
                            ->is('large')
                            ->is('white')
                            ->with('title', $parent->vars()->name.' › ')
                            ->with('route', route('v2.destination.show', [$parent]));
                    }))
                )
                ->push(component('Title')
                    ->is('white')
                    ->is('large')
                    ->with('title', $destination->name)
                )
                ->push(component('Body')
                    ->is('white')
                    ->is('responsive')
                    ->with('body', $destination->vars()->description)
                )
                ->push(component('Meta')
                    ->is('large')
                    ->with('items', $destination
                        ->getImmediateDescendants()
                        ->map(function ($destination) {
                            return component('Tag')
                                ->is('white')
                                ->is('large')
                                ->with('title', $destination->name)
                                ->with('route', route('v2.destination.show', [$destination]));
                    }))
                )
                ->push(component('DestinationFacts')
                    ->with('facts', collect()
                        ->putWhen(
                            $destination->vars()->isCountry || $destination->vars()->isPlace,
                            trans('destination.show.about.callingCode'),
                            $destination->vars()->callingCode()
                        )
                        ->putWhen(
                            $destination->vars()->isCountry || $destination->vars()->isPlace,
                            trans('destination.show.about.currencyCode'),
                            $destination->vars()->currencyCode()
                        )
                    )
                )
                ->push(component('DestinationFacts')
                    ->with('facts', collect()
                        ->putWhen(
                            $destination->vars()->isCountry,
                            trans('destination.show.about.area'),
                            $destination->vars()->area()
                        )
                        ->putWhen(
                            $destination->vars()->isCountry,
                            trans('destination.show.about.population'),
                            $destination->vars()->population()
                        )
                    )
                )
                ->push(component('BlockHorizontal')->with('content', collect()
                    ->push(component('StatCard')
                        ->with('icon', 'icon-pin')
                        ->with('title', $destination
                            ->vars()->usersWantsToGo()->count()
                        )
                    )
                    ->push(component('StatCard')
                        ->with('icon', 'icon-star')
                        ->with('title', $destination
                            ->vars()->usersHaveBeen()->count()
                        )
                    )
                ))
            );
    }
}
