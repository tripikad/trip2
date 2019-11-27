<?php

namespace App\Http\Controllers\Styleguide;

use App\Http\Controllers\Controller;
use App\Content;

class GridController extends Controller
{
    public function index()
    {
        $photos = Content::getLatestItems('photo', 6);

        return layout('Two')
            ->with('title', 'Styles')
            ->with(
                'content',
                collect()
                    ->push(region('StyleguideMenu'))
                    ->push(component('Title')->with('title', 'Grids'))
                    ->push(
                        component('Title')
                            ->is('small')
                            ->with('title', 'Flex')
                    )
                    ->merge($this->row($photos))
                    ->br()
                    ->push(
                        component('Title')
                            ->is('small')
                            ->with('title', 'FlexGrid')
                    )
                    ->merge($this->flexGrid($photos))
                    ->br()
                    ->push(
                        component('Title')
                            ->is('small')
                            ->with('title', 'Grid')
                    )
                    ->merge($this->grid($photos))
            )
            ->render();
    }

    public function row($photos)
    {
        return collect()
            ->push(
                component('Code')
                    ->is('gray')
                    ->with(
                        'code',
                        "component('Flex')
    ->with('gap', 'md') // resolves to 2 * \$spacer. Can also be a number
    ->with('items', \$photos->take(4)->map(function (\$photo) {
      return component('Title')
          ->is('smallest')
          ->with('title', \$photo->vars()->shortTitle);
  }))"
                    )
            )
            ->push(
                component('Flex')
                    ->with('gap', 'md')
                    ->with(
                        'items',
                        $photos->take(4)->map(function ($photo) {
                            return component('Title')
                                ->is('smallest')
                                ->with('title', $photo->vars()->shortTitle);
                        })
                    )
            )
            ->push(
                component('Code')
                    ->is('gray')
                    ->with(
                        'code',
                        "component('Flex')
  ->is('debug')                              // Debug mode
  ->with('justify-content', 'space-between') // flex-start is default
  ->with('align-items', 'flex-start')        // center is default
  ->with('items', \$photos->take(2)->map(function (\$photo) {
    return component('Title')
        ->is('smallest')
        ->with('title', \$photo->vars()->shortTitle);
}))"
                    )
            )
            ->push(
                component('Flex')
                    ->is('debug')
                    ->with('gap', 'md')
                    ->with('justify', 'space-between')
                    ->with(
                        'items',
                        $photos->take(2)->map(function ($photo) {
                            return component('Title')
                                ->is('smallest')
                                ->with('title', $photo->vars()->shortTitle);
                        })
                    )
            );
    }

    public function flexGrid($photos)
    {
        return collect()
            ->push(
                component('Code')
                    ->is('gray')
                    ->with(
                        'code',
                        "component('FlexGrid')
    ->with('cols', 2) // Default is 3
    ->with('items', \$photos->take(4)->...)"
                    )
            )
            ->push(
                component('FlexGrid')
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
            )
            ->push(
                component('Code')
                    ->is('gray')
                    ->with(
                        'code',
                        "component('FlexGrid')
  ->is('debug')                   // Debug mode
  ->with('gap', 'sm')             // Resolves to 1 * \$spacer. Can be a number
  ->with('widths', '2fr 3fr 2fr') // 5/2 5/3 5/2 column widths 
  ->with('items', \$photos->take(6)->...)"
                    )
            )
            ->push(
                component('FlexGrid')
                    ->is('debug')
                    ->with('gap', 1)
                    ->with('widths', '2fr 3fr 2fr')
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

    public function grid($photos)
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
                        "component('Grid')
    ->with('gap', 'sm') // Resolves to 1 * \$spacer. Can be a number
    ->with('widths', '1fr 2fr') // maps to grid-template-columns
    ->with('heights', '2fr 1fr 2fr') // maps to grid-template-rows
    ->with('items', \$photos->take(6)->...)"
                    )
            )
            ->push(
                component('Grid')
                    ->with('gap', 'sm')
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
