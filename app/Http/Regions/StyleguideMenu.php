<?php

namespace App\Http\Regions;

class StyleguideMenu
{
    public function render()
    {
        return component('Flex')->with(
            'items',
            collect([
                [
                    'title' => 'Styleguide',
                    'route' => 'styleguide.index'
                ],
                [
                    'title' => 'Colors',
                    'route' => 'styleguide.colors.index'
                ],
                [
                    'title' => 'Components',
                    'route' => 'styleguide.components.index'
                ],
                [
                    'title' => 'Component preview',
                    'route' => 'styleguide.components.index',
                    'preview' => true
                ],
                [
                    'title' => 'Fonts',
                    'route' => 'styleguide.fonts.index'
                ],
                ['title' => 'Grid', 'route' => 'styleguide.grid.index'],
                ['title' => 'Icons', 'route' => 'styleguide.icons.index']
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
