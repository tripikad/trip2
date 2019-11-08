<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Support\Facades\Storage;

class StyleguideController extends Controller
{
    protected function mdfile($filename)
    {
        return $this->md(
            file_get_contents(
                Storage::disk('resources')->path(
                    '/views/md/' . $filename . '.md'
                )
            )
        );
    }

    protected function md($md)
    {
        return component('Body')->with('body', format_body($md));
    }

    public function index()
    {
        $photos = Content::getLatestItems('photo', 6);

        return layout('Two')
            ->with('title', 'Cusco')
            ->with(
                'content',
                collect()
                    ->push(component('StyleTitle')->with('title', 'Cusco'))
                    ->push(
                        component('Body')
                            ->is('larger')
                            ->with(
                                'body',
                                format_body(
                                    'Component library and CSS styleguide for Trip.ee. Shouldn\'t it be called a *design system*?'
                                )
                            )
                    )
                    ->push(
                        component('Title')
                            ->is('large')
                            ->with('title', 'Making a component')
                    )
                    ->push($this->mdfile('makingcomponent'))
                    ->push(
                        component('Title')
                            ->is('large')
                            ->with('title', 'Typopgraphy')
                    )
                    ->push(
                        $this->md('
                        For headings and body texts we use [Sailec](https://www.myfonts.com/fonts/typedynamic/sailec) by Nico Inosanto . For code snippets we use [Cousine](https://fonts.google.com/specimen/Cousine) by Steve Matteson. The typefaces are picked for optimum legibility and also for standing out from regular web font choices.

                        # Text

                        ## Default text size

                        In most cases, you can rely on default body text size `$font-text-md`. 

                        <!--
                        Do not use full black on text color, the darkest shade of gray should be `$gray-dark`.
                        -->

                        ```
                        .SomeComponent__text {
                          font: $font-text-md;
                        }
                        ```

                        ## Larger text size

                        Go **one size up** `$font-text-lg` when you need to emphasize the text (citations).

                        ## Small text size

                        Go iate **one size down** `$font-text-sm` when you need to de-emphasize the text (impressum in the footer) or make the text more compact (secondary UI elements).

                        ## All text sizes

                        Text CSS variables are defined as following:

                        ---
                        ')
                    )
                    ->merge($this->fonts('font-text'))
                    ->push(
                        $this->md('
                        ---

                        <ins>TODO</ins> Reduce number of font size variations. `$font-text-xs` can likely be unified with `$font-text-sm`?
                    
                        # Headings

                        The smallest heading size for particular text size has the same size modifier `sm` / `md` / `lg` etc.

                        ```
                        .SomeComponent__heading {
                          font: $font-heading-md;
                        }
                        .SomeComponent__text {
                          font: $font-text-md;
                        }
                        ```

                        <mark>Tip</mark> The optimal heading size for particular text size is actually **one size up**.

                        ```
                        .SomeComponent__heading {
                          font: $font-heading-lg; /* Better */
                        }
                        .SomeComponent__text {
                          font: $font-text-md;
                        }
                        ```

                        Below are all the heading sizes:

                        ---
                    ')
                    )
                    ->merge($this->fonts('font-heading'))
                    ->push(
                        $this->md('
                        ---

                        # Code 

                        Usually the monospaced typography for code snippets is kept for internal usage and is not exposed to a general user but can be usefult in admin interfaces (Markdown editor, code experiments etc).

                        <mark>Tip</mark> Use `$font-code-sm` for lables and code snippets.

                        <mark>Tip</mark> Use `$font-code-md` for code editors.

                        Below are all the code sizes:

                        ---
                      ')
                    )
                    ->merge($this->fonts('font-code'))
                    ->push('&nbsp;')
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

    public function fonts($type)
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
            ->filter(function ($value, $key) use ($type) {
                return starts_with(
                    $key,
                    $type /*[
                    'font-text',
                    'font-heading',
                    'font-code'
                ]*/
                );
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
