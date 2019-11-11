<?php

namespace App\Http\Controllers\Styleguide;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class FontsController extends StyleguideController
{
    public function index()
    {
        return layout('Two')
            ->with('header', $this->header())
            ->with(
                'content',
                collect()
                    ->push(
                        component('Title')
                            ->is('large')
                            ->with('title', 'Fonts')
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
            )
            ->with('footer', $this->footer())
            ->render();
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
