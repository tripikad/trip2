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
                    [
                        'title' => 'Components',
                        'route' => 'experiments.components.index'
                    ],
                    ['title' => 'Grid', 'route' => 'experiments.grid.index'],
                    ['title' => 'Icons', 'route' => 'experiments.icons.index'],
                    [
                        'title' => 'Fonts and spacing',
                        'route' => 'experiments.styles.index'
                    ]
                ])->map(function ($link) {
                    return component('Title')
                        ->is('blue')
                        ->is('smallest')
                        ->with('title', $link['title'])
                        ->with('route', route($link['route']));
                })
            );
    }
}
