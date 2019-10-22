<?php

namespace App\Http\Controllers;
<<<<<<< HEAD
use App\Content;
=======
>>>>>>> origin/kika-offers-2

class StyleController extends Controller
{
    public function colors()
    {
        return collect(styleVars())
            ->filter(function ($value, $key) {
                return ! ends_with($key, '-hover') &&
                    starts_with($value, 'hsl');
            })
            ->map(function ($value, $key) {
                return component('StyleColor')
                    ->with('key', $key)
                    ->with('value', $value);
            });
    }

    public function colors2()
    {
        $colors = collect(styleVars())
            ->filter(function ($value, $key) {
                return !ends_with($key, '-hover') &&
                    starts_with($value, 'hsl');
            })
            ->map(function ($value, $key) {
                return '<div style="background: ' . $value . '"><br><br><br></div>';
            });

        return component('ExperimentalGrid')->with('cols', 12)->with('items', $colors)->render();
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
                        $photos
                            ->take(4)
                            ->map(function ($photo) {
                                return component(
                                    'ExperimentalCard'
                                )
                                    ->with(
                                        'title',
                                        $photo->vars()
                                            ->shortTitle
                                    )
                                    ->with(
                                        'background',
                                        $photo->imagePreset(
                                            'medium'
                                        )
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
                        $photos
                            ->take(6)
                            ->map(function ($photo) {
                                return component(
                                    'ExperimentalCard'
                                )
                                    ->with(
                                        'title',
                                        $photo->vars()
                                            ->shortTitle
                                    )
                                    ->with(
                                        'background',
                                        $photo->imagePreset(
                                            'medium'
                                        )
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
                            return component(
                                'ExperimentalCard'
                            )
                                ->with(
                                    'title',
                                    $photo->vars()
                                        ->shortTitle
                                )
                                ->with(
                                    'background',
                                    $photo->imagePreset(
                                        'medium'
                                    )
                                );
                        })
                    )
            );
    }

    public function spacings()
    {
        $spacer = styleVars()->spacer;

        return collect(styleVars())
            ->filter(function ($value, $key) {
                return starts_with($key, 'padding-');
            })
            ->map(function ($value, $key) use ($spacer) {
                return component('StyleSpacing')
                    ->with('key', $key)
                    ->with(
                        'value',
                        str_replace(
                            '$spacer',
                            $spacer,
                            $value
                        )
                    );
            });
    }

    public function widths()
    {
        $spacer = styleVars()->spacer;

        return collect(styleVars())
            ->filter(function ($value, $key) {
                return starts_with($key, 'width-');
            })
            ->map(function ($value, $key) use ($spacer) {
                return component('StyleSpacing')
                    ->with('key', $key)
                    ->with(
                        'value',
                        str_replace(
                            '$spacer',
                            $spacer,
                            $value
                        )
                    );
            });
    }

    public function fonts()
    {
        $fontSizeXs = styleVars()->{'font-size-xs'};
        $fontSizeSm = styleVars()->{'font-size-sm'};
        $fontSizeMd = styleVars()->{'font-size-md'};
        $fontSizeLg = styleVars()->{'font-size-lg'};
        $fontSizeXl = styleVars()->{'font-size-xl'};
        $fontSizeXxl = styleVars()->{'font-size-xxl'};
        $fontSizeXxxl = styleVars()->{'font-size-xxxl'};
        $fontSizeXxxxl = styleVars()->{'font-size-xxxxl'};

        $lineHeightXs = styleVars()->{'line-height-xs'};
        $lineHeightSm = styleVars()->{'line-height-sm'};
        $lineHeightMd = styleVars()->{'line-height-md'};
        $lineHeightLg = styleVars()->{'line-height-lg'};
        $lineHeightXl = styleVars()->{'line-height-xl'};
        $lineHeightXXl = styleVars()->{'line-height-xxl'};

        return collect(styleVars())
            ->filter(function ($value, $key) {
                return starts_with($key, [
                    'font-text',
                    'font-heading',
                    'font-code'
                ]);
            })
            ->map(function ($value, $key) use (
                $fontSizeXs,
                $fontSizeSm,
                $fontSizeMd,
                $fontSizeLg,
                $fontSizeXl,
                $fontSizeXxl,
                $fontSizeXxxl,
                $fontSizeXxxxl,
                $lineHeightXs,
                $lineHeightSm,
                $lineHeightMd,
                $lineHeightLg,
                $lineHeightXl,
                $lineHeightXXl
            ) {
                return component('StyleFont')
                    ->with('key', $key)
                    ->with(
                        'value',
                        str_replace(
                            [
                                '$font-size-xs',
                                '$font-size-sm',
                                '$font-size-md',
                                '$font-size-lg',
                                '$font-size-xl',
                                '$font-size-xxl',
                                '$font-size-xxxl',
                                '$font-size-xxxxl',
                                '$line-height-xs',
                                '$line-height-sm',
                                '$line-height-md',
                                '$line-height-lg',
                                '$line-height-xl',
                                '$line-height-xxl',
                                '$font-weight-normal',
                                '$font-weight-semibold',
                                '$font-weight-bold',
                                '$font-family',
                                '-code',
                                'sans-serif',
                                '/ ',
                                ','
                            ],
                            [
                                $fontSizeXs .
                                    ' (font-size-xs)',
                                $fontSizeSm .
                                    ' (font-size-sm)',
                                $fontSizeMd .
                                    ' (font-size-md)',
                                $fontSizeLg .
                                    ' (font-size-lg)',
                                $fontSizeXl .
                                    ' (font-size-xl)',
                                $fontSizeXxl .
                                    ' (font-size-xxl)',
                                $fontSizeXxxl .
                                    ' (font-size-xxxl)',
                                $fontSizeXxxxl .
                                    ' (font-size-xxxx;)',
                                $lineHeightXs .
                                    ' (line-height-xs)',
                                $lineHeightSm .
                                    ' (line-height-sm)',
                                $lineHeightMd .
                                    ' (line-height-md)',
                                $lineHeightLg .
                                    ' (line-height-lg)',
                                $lineHeightXl .
                                    ' (line-height-xl)',
                                $lineHeightXXl .
                                    ' (line-height-xxl)',
                                'normal',
                                'semibold',
                                'bold',
                                '',
                                '',
                                '',
                                '',
                                ''
                            ],
                            $value
                        )
                    );
            });
    }

    public function index()
    {
        $photos = Content::getLatestItems('photo', 6);

        return layout('Two')
            ->with(
                'content',
                collect()
                    ->push(
                        component('Title')
                            ->is('large')
                            ->with('title', 'Styles')
                    )
                    ->push(
                        component('Title')
                            ->is('small')
                            ->with('title', 'Fonts')
                    )
                    ->merge($this->fonts())
                    ->push('&nbsp;')
                    ->push(
                        component('Title')
                            ->is('medium')
                            ->with(
                                'title',
                                'Spacings and paddings'
                            )
                    )
                    ->push(
                        component('Grid')
                            ->with('cols', 2)
                            ->with(
                                'items',
                                collect()
                                    ->push(
                                        $this->spacings()
                                            ->render()
                                            ->implode(
                                                '<br>'
                                            )
                                    )
                                    ->push(
                                        '<div style="height: calc(12px * 11.5);">&nbsp</div>' .
                                            $this->widths()
                                                ->render()
                                                ->implode(
                                                    '<br>'
                                                )
                                    )
                            )
                    )
                    ->push(
                        component('Title')
                            ->is('small')
                            ->with('title', 'Colors')
                    )
                    ->merge($this->colors2())
                    ->push('&nbsp;')
                    ->merge($this->colors())
                    ->push('&nbsp;')
                    ->push(
                        component('Title')
                            ->is('medium')
                            ->with(
                                'title',
                                'Flexbox grid I'
                            )
                    )
                    ->merge($this->grid($photos))
                    ->push('&nbsp;')
                    ->push(
                        component('Title')
                            ->is('medium')
                            ->with(
                                'title',
                                'Flexbox grid II'
                            )
                    )
                    ->merge($this->grid2($photos))
                    ->push('&nbsp;')
                    ->push(
                        component('Title')
                            ->is('medium')
                            ->with(
                                'title',
                                'Experimental CSS grid'
                            )
                    )
                    ->merge($this->grid3($photos))
            )
            ->render();
    }
}
