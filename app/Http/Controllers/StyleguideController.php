<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Support\Facades\Storage;

class StyleguideController extends Controller
{
    public function index()
    {
        $photos = Content::getLatestItems('photo', 6);

        return layout('Two')
            ->with('title', 'Styles')
            ->with(
                'content',
                collect()
                    ->push(
                        component('Title')
                            ->is('large')
                            ->with('title', 'Styleguide')
                    )
                    ->push(
                        component('Title')
                            ->is('small')
                            ->with('title', 'Icons')
                    )
                    ->push(
                        component('Code')
                            ->is('gray')
                            ->with('code', '{ sm: 14, md: 18, lg: 26, xl: 36 }')
                    )
                    ->merge($this->iconComponents())
                    ->push(
                        component('Title')
                            ->is('large')
                            ->with('title', 'Fonts')
                    )
                    ->push(
                        component('Body')
                            ->is('large')
                            ->with(
                                'body',
                                format_body(
                                    file_get_contents(
                                        Storage::disk('resources')->path(
                                            '/views/texts/fonts.md'
                                        )
                                    )
                                )
                            )
                    )
                    ->merge($this->fonts())
                    ->push('&nbsp;')
                    ->push(
                        component('Title')
                            ->is('medium')
                            ->with('title', 'Spacings and paddings')
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
                                            ->implode('<br>')
                                    )
                                    ->push(
                                        '<div style="height: calc(12px * 11.5);">&nbsp</div>' .
                                            $this->widths()
                                                ->render()
                                                ->implode('<br>')
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
                            ->with('title', 'Flexbox grid I')
                    )
                    ->merge($this->grid($photos))
                    ->push('&nbsp;')
                    ->push(
                        component('Title')
                            ->is('medium')
                            ->with('title', 'Flexbox grid II')
                    )
                    ->merge($this->grid2($photos))
                    ->push('&nbsp;')
                    ->push(
                        component('Title')
                            ->is('medium')
                            ->with('title', 'Experimental CSS grid')
                    )
                    ->merge($this->grid3($photos))
            )
            ->render();
    }
    // private function svgFiles()
    // {
    //     return collect(Storage::disk('resources')->files('/views/svg'))->map(
    //         function ($file) {
    //             return str_limit(
    //                 file_get_contents(Storage::disk('resources')->path($file)),
    //                 200
    //             );
    //         }
    //     );
    // }

    private $iconSizes = ['sm', 'md', 'lg', 'xl'];

    private function iconComponents()
    {
        return collect(Storage::disk('resources')->files('/views/svg'))
            ->map(function ($file) {
                return str_replace(['.svg'], '', basename($file));
            })
            ->map(function ($file, $index) {
                return collect()
                    ->push(
                        component('Title')
                            ->is('small')
                            ->with(
                                'title',
                                str_replace(['-', 'icon'], ' ', $file)
                            )
                    )
                    // ->push(
                    //     component('Code')
                    //         ->is('gray')
                    //         ->with(
                    //             'code',
                    //             $file . "\n\n" . $this->svgFiles()[$index]
                    //         )
                    // )
                    ->merge(
                        collect($this->iconSizes)
                            ->map(function ($size) use ($file) {
                                return collect()
                                    ->push(
                                        component('Code')
                                            ->is('gray')
                                            ->with(
                                                'code',
                                                "component('Icon')->with('icon','" .
                                                    $file .
                                                    "')->with('size','" .
                                                    $size .
                                                    "')"
                                            )
                                    )
                                    ->push(
                                        '<div class="StyleIcon">' .
                                            component('Icon')
                                                ->with('size', $size)
                                                ->with('icon', $file)
                                                ->render() .
                                            '</div>'
                                    );
                            })
                            ->flatten()
                    )
                    ->flatten();
            })
            ->flatten()
            ->push(component('StyleIcon'));
    }

    public function colors()
    {
        return collect(styleVars())
            ->filter(function ($value, $key) {
                return !ends_with($key, '-hover') && starts_with($value, 'hsl');
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
                return !ends_with($key, '-hover') && starts_with($value, 'hsl');
            })
            ->map(function ($value, $key) {
                return '<div style="background: ' .
                    $value .
                    '"><br><br><br></div>';
            });

        return component('ExperimentalGrid')
            ->with('cols', 12)
            ->with('items', $colors)
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
                    ->with('value', str_replace('$spacer', $spacer, $value));
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
                    ->with('value', str_replace('$spacer', $spacer, $value));
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
                                    ' (<span class="hljs-string">$font-size-xs</span>)',
                                $fontSizeSm .
                                    ' (<span class="hljs-string">$font-size-sm</span>)',
                                $fontSizeMd .
                                    ' (<span class="hljs-string">font-size-md</span>)',
                                $fontSizeLg .
                                    ' (<span class="hljs-string">font-size-lg</span>)',
                                $fontSizeXl .
                                    ' (<span class="hljs-string">font-size-xl</span>)',
                                $fontSizeXxl .
                                    ' (<span class="hljs-string">font-size-xxl</span>)',
                                $fontSizeXxxl .
                                    ' (<span class="hljs-string">font-size-xxxl</span>)',
                                $fontSizeXxxxl .
                                    ' (<span class="hljs-string">font-size-xxxx</span>)',
                                $lineHeightXs .
                                    ' (<span class="hljs-string">line-height-xs</span>)',
                                $lineHeightSm .
                                    ' (<span class="hljs-string">line-height-sm</span>)',
                                $lineHeightMd .
                                    ' (<span class="hljs-string">line-height-md</span>)',
                                $lineHeightLg .
                                    ' (<span class="hljs-string">line-height-lg</span>)',
                                $lineHeightXl .
                                    ' (<span class="hljs-string">line-height-xl</span>)',
                                $lineHeightXXl .
                                    ' (<span class="hljs-string">line-height-xxl)',
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
}
