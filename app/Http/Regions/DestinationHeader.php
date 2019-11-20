<?php

namespace App\Http\Regions;

class DestinationHeader
{
    public function render($destination, $user)
    {
        $parents = $destination->getAncestors();
        $childrens = $destination->getImmediateDescendants()->sortBy('name');

        $body = $destination->description
            ? $destination->vars()->description
            : '';
        if ($body && $destination->user) {
            $body .=
                ' (<a href="' .
                route('user.show', [$destination->user]) .
                '">' .
                $destination->user->name .
                '</a>)';
        }

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
                    ->push(region('DestinationHeaderParents', $parents))
                    ->push(
                        component('Flex')
                            ->with('align', 'flex-start')
                            ->with('justify', 'space-between')
                            ->with(
                                'items',
                                collect()
                                    ->push(
                                        region(
                                            'DestinationHeaderAbout',
                                            $destination,
                                            $user
                                        )
                                    )
                                    ->push(
                                        region('DestinationMap', $destination)
                                    )
                            )
                    )
                    ->push(region('DestinationStat', $destination))
                    ->pushWhen(
                        $destination->description,
                        component('Body')
                            ->is('yellow-dark')
                            ->is('responsive')
                            ->with(
                                'body',
                                format_body($destination->description)
                            )
                    )
                    ->pushWhen(
                        $destination->user,
                        region('UserRow', $destination->user)
                    )
                    ->pushWhen(
                        $childrens->count(),
                        component('Flex')
                            ->is('wrap')
                            ->with('gap', 0.5)
                            ->is('large')
                            ->with(
                                'items',
                                $childrens->map(function ($children) {
                                    return component('Tag')
                                        ->is('white')
                                        ->is('large')
                                        ->with('title', $children->name)
                                        ->with(
                                            'route',
                                            route('destination.showSlug', [
                                                $children->slug
                                            ])
                                        );
                                })
                            )
                    )
            );
    }
}
