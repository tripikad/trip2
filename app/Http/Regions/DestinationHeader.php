<?php

namespace App\Http\Regions;

class DestinationHeader
{
    public function render($destination)
    {
        $parents = $destination->getAncestors();
        $childrens = $destination->getImmediateDescendants()->sortBy('name');

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
                ->push(region('DestinationParents', $parents))
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
                ->pushWhen($childrens->count(), component('Meta')
                    ->is('large')
                    ->with('items', $childrens->map(function ($children) {
                        return component('Tag')
                            ->is('white')
                            ->is('large')
                            ->with('title', $children->name)
                            ->with('route', route('destination.show', [$children]));
                    }))
                )
                ->push(component('BlockHorizontal')
                    ->is('between')
                    ->is('bottom')
                    ->with('content', collect()
                        ->push(region('DestinationFacts', $destination))
                        ->push(region('DestinationStat', $destination))
                    )
                )
            );
    }
}
