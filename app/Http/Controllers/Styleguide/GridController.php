<?php

namespace App\Http\Controllers\Styleguide;

use App\Content;

class GridController extends StyleguideController
{
    public function index()
    {
        $photos = Content::getLatestItems('photo', 6);

        return layout('Two')
            ->with('header', $this->header())
            ->with(
                'content',
                collect()
                    ->push(
                        component('Title')
                            ->is('large')
                            ->with('title', 'Using grid')
                    )
                    ->push(
                        component('Title')
                            ->is('small')
                            ->with('title', 'Flexbox grid')
                    )
                    ->merge($this->grid($photos))
                    ->push(
                        component('Title')
                            ->is('small')
                            ->with('title', 'Advanced flexbox grid')
                    )
                    ->merge($this->grid2($photos))
                    ->push(
                        component('Title')
                            ->is('small')
                            ->with('title', 'Css grid')
                    )
                    ->merge($this->grid3($photos))
            )
            ->with('footer', $this->footer())
            ->render();
    }

    public function grid($photos)
    {
        return collect()
            ->push(
                component('Code')
                    ->is('gray')
                    ->with(
                        'code',
                        "component('Grid')
    ->with('cols', 2) // Default is 3
    ->with('items', \$photos->take(4)->...)"
                    )
            )
            ->push(
                component('Grid')
                    ->with('cols', 2)
                    ->with(
                        'items',
                        $photos->take(4)->map(function ($photo) {
                            return component('ExperimentalCard')
                                ->with('title', $photo->vars()->shortTitle)
                                ->with(
                                    'background',
                                    $photo->imagePreset('medium')
                                );
                        })
                    )
            );
    }

    public function grid2($photos)
    {
        return collect()
            ->push(
                component('Code')
                    ->is('gray')
                    ->with(
                        'code',
                        "component('Grid')
    ->with('gap', 1) // \$spacer * 1 || 2
    ->with('widths', '2 3 2') // maps to flex:2, flex:3, flex:2 on columns
    ->with('items', \$photos->take(6)->...)"
                    )
            )
            ->push(
                component('Grid')
                    ->with('gap', 1)
                    ->with('widths', '2 3 2')
                    ->with(
                        'items',
                        $photos->take(6)->map(function ($photo) {
                            return component('ExperimentalCard')
                                ->with('title', $photo->vars()->shortTitle)
                                ->with(
                                    'background',
                                    $photo->imagePreset('medium')
                                );
                        })
                    )
            );
    }

    public function grid3($photos)
    {
        return collect()
            ->push(
                component('Body')->with(
                    'body',
                    'Only supported in <a href="https://caniuse.com/css-grid">latest browsers</a>'
                )
            )
            ->push(
                component('Code')
                    ->is('gray')
                    ->with(
                        'code',
                        "component('ExperimentalGrid')
    ->with('gap', 1) // \$spacer * anything
    ->with('widths', '1fr 2fr') // maps to grid-template-columns
    ->with('heights', '2fr 1fr 2fr') // maps to grid-template-rows
    ->with('items', \$photos->take(6)->...)"
                    )
            )
            ->push(
                component('ExperimentalGrid')
                    ->with('gap', 1)
                    ->with('widths', '1fr 2fr')
                    ->with('heights', '2fr 1fr 2fr')
                    ->with(
                        'items',
                        $photos->map(function ($photo) {
                            return component('ExperimentalCard')
                                ->with('title', $photo->vars()->shortTitle)
                                ->with(
                                    'background',
                                    $photo->imagePreset('medium')
                                );
                        })
                    )
            );
    }
}
