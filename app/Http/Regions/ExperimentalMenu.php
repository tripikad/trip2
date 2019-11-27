<?php

namespace App\Http\Regions;

class ExperimentalMenu
{
    public function render()
    {
        return component('Flex')->with(
            'items',
            collect([
                ['title' => 'Grid', 'route' => 'experiments.grid.index'],
                [
                    'title' => 'Components',
                    'route' => 'experiments.components.index'
                ],
                [
                    'title' => 'Component preview',
                    'route' => 'experiments.components.index',
                    'preview' => true
                ],
                ['title' => 'Icons', 'route' => 'experiments.icons.index'],
                [
                    'title' => 'Fonts',
                    'route' => 'experiments.fonts.index'
                ],
                [
                    'title' => 'Colors',
                    'route' => 'experiments.colors.index'
                ]
            ])->map(function ($link) {
                return component('Title')
                    ->is('blue')
                    ->is('smallest')
                    ->with('title', $link['title'])
                    ->with(
                        'route',
                        route(
                            $link['route'],
                            array_key_exists('preview', $link)
                                ? ['preview']
                                : null
                        )
                    );
            })
        );
    }
}
