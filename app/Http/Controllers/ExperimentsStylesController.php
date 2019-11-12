<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Support\Facades\Storage;

class ExperimentsStylesController extends Controller
{
    public function index()
    {
        return layout('Two')
            ->with('title', 'Styles')
            ->with(
                'content',
                collect()
                    ->push(region('ExperimentalMenu'))
                    ->push(
                        component('Title')->with('title', 'Fonts and spacing')
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
            )
            ->render();
    }

    public function colors()
    {
        return collect(style_vars())
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
        $colors = collect(style_vars())
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

    public function spacings()
    {
        $spacer = style_vars()->spacer;

        return collect(style_vars())
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
        $spacer = style_vars()->spacer;

        return collect(style_vars())
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
        $fontSizeXs = style_vars()->{'font-size-xs'};
        $fontSizeSm = style_vars()->{'font-size-sm'};
        $fontSizeMd = style_vars()->{'font-size-md'};
        $fontSizeLg = style_vars()->{'font-size-lg'};
        $fontSizeXl = style_vars()->{'font-size-xl'};
        $fontSizeXxl = style_vars()->{'font-size-xxl'};
        $fontSizeXxxl = style_vars()->{'font-size-xxxl'};
        $fontSizeXxxxl = style_vars()->{'font-size-xxxxl'};

        $lineHeightXs = style_vars()->{'line-height-xs'};
        $lineHeightSm = style_vars()->{'line-height-sm'};
        $lineHeightMd = style_vars()->{'line-height-md'};
        $lineHeightLg = style_vars()->{'line-height-lg'};
        $lineHeightXl = style_vars()->{'line-height-xl'};
        $lineHeightXXl = style_vars()->{'line-height-xxl'};

        return collect(style_vars())
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
                                $fontSizeXs . ' (font-size-xs)',
                                $fontSizeSm . ' (font-size-sm)',
                                $fontSizeMd . ' (font-size-md)',
                                $fontSizeLg . ' (font-size-lg)',
                                $fontSizeXl . ' (font-size-xl)',
                                $fontSizeXxl . ' (font-size-xxl)',
                                $fontSizeXxxl . ' (font-size-xxxl)',
                                $fontSizeXxxxl . ' (font-size-xxxx;)',
                                $lineHeightXs . ' (line-height-xs)',
                                $lineHeightSm . ' (line-height-sm)',
                                $lineHeightMd . ' (line-height-md)',
                                $lineHeightLg . ' (line-height-lg)',
                                $lineHeightXl . ' (line-height-xl)',
                                $lineHeightXXl . ' (line-height-xxl)',
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
