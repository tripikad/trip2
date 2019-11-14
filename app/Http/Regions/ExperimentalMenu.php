<?php

namespace App\Http\Regions;

class ExperimentalMenu
{
    public function render()
    {
        return component('ExperimentalRow')
            ->with('gap', 'lg')
            ->with(
                'items',
                collect([
                    ['title' => 'Experiments', 'route' => 'experiments.index'],
                    ['title' => 'Grid', 'route' => 'experiments.grid.index'],
                    [
                        'title' => 'Components',
                        'route' => 'experiments.components.index'
                    ],
                    [
                        'title' => 'Comp. preview',
                        'route' => 'experiments.components.index',
                        'preview' => true
                    ],
                    ['title' => 'Icons', 'route' => 'experiments.icons.index'],
                    [
                        'title' => 'Styles',
                        'route' => 'experiments.styles.index'
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
