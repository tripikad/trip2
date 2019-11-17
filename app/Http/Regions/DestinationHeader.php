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
                    ->push(
                        component('Flex')
                            ->with('align', 'flex-start')
                            ->with('justify', 'space-between')
                            ->with(
                                'items',
                                collect()
                                    ->push(
                                        collect()
                                            ->push(
                                                region(
                                                    'DestinationParents',
                                                    $parents
                                                )
                                            )
                                            ->push(
                                                component('Title')
                                                    ->is('large')
                                                    ->is('white')
                                                    ->with(
                                                        'title',
                                                        $destination->name
                                                    )
                                            )
                                            ->pushWhen(
                                                $user &&
                                                    $user->hasRole('admin'),
                                                component('MetaLink')
                                                    ->is('white')
                                                    ->with(
                                                        'title',
                                                        trans(
                                                            'content.action.edit.title'
                                                        )
                                                    )
                                                    ->with(
                                                        'route',
                                                        route(
                                                            'destination.edit',
                                                            [$destination]
                                                        )
                                                    )
                                            )
                                            ->push(
                                                region(
                                                    'DestinationFacts',
                                                    $destination
                                                )
                                            )
                                            ->render()
                                            ->implode('<br />')
                                    )
                                    ->push(
                                        region('DestinationMap', $destination)
                                    )
                            )
                    )
                    ->push(
                        component('Flex')
                            ->with('justify', 'space-between')
                            ->with(
                                'items',
                                collect()
                                    ->pushWhen(
                                        $destination->description,
                                        collect()
                                            ->pushWhen(
                                                $destination->description,
                                                component('Body')
                                                    ->is('white')
                                                    ->is('responsive')
                                                    ->with(
                                                        'body',
                                                        $destination->description
                                                    )
                                            )
                                            ->pushWhen(
                                                $destination->user,
                                                component('Flex')
                                                    ->with('gap', 1)
                                                    ->with(
                                                        'items',
                                                        collect()
                                                            ->push(
                                                                component(
                                                                    'UserImage'
                                                                )
                                                                    ->with(
                                                                        'route',
                                                                        route(
                                                                            'user.show',
                                                                            [
                                                                                $destination->user
                                                                            ]
                                                                        )
                                                                    )
                                                                    ->with(
                                                                        'image',
                                                                        $destination->user
                                                                            ? $destination->user->imagePreset(
                                                                                'small_square'
                                                                            )
                                                                            : ''
                                                                    )
                                                                    ->with(
                                                                        'rank',
                                                                        $destination->user
                                                                            ? $destination->user->vars()
                                                                                ->rank
                                                                            : ''
                                                                    )
                                                            )
                                                            ->push(
                                                                component(
                                                                    'Title'
                                                                )
                                                                    ->is(
                                                                        'white'
                                                                    )
                                                                    ->is(
                                                                        'smallest'
                                                                    )
                                                                    ->with(
                                                                        'title',
                                                                        $destination->user
                                                                            ? $destination
                                                                                ->user
                                                                                ->name
                                                                            : ''
                                                                    )
                                                            )
                                                    )
                                            )
                                            ->render()
                                            ->implode('<br />')
                                    )
                                    ->push(
                                        region('DestinationStat', $destination)
                                    )
                            )
                    )
                    ->pushWhen(
                        $childrens->count(),
                        component('Meta')
                            ->is('large')
                            ->with(
                                'items',
                                $childrens->map(function ($children) {
                                    return component('Tag')
                                        ->is('white')
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
