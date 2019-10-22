<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

class StyleController extends Controller
{
    public function colors()
    {
        return collect(styleVars())
            ->filter(function ($value, $key) {
                return !ends_with($key, '-hover') &&
                    starts_with($value, 'hsl');
            })
            ->map(function ($value, $key) {
                return component('StyleColor')
                    ->with('key', $key)
                    ->with('value', $value);
            });
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
            ->dump()
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
                                '$font-family-code',
                                'sans-serif',
                                '/ ',
                                ','
                            ],
                            [
                                $fontSizeXs. ' (font-size-xs)',
                                $fontSizeSm. ' (font-size-sm)',
                                $fontSizeMd. ' (font-size-md)',
                                $fontSizeLg. ' (font-size-lg)',
                                $fontSizeXl. ' (font-size-xl)',
                                $fontSizeXxl. ' (font-size-xxl)',
                                $fontSizeXxxl. ' (font-size-xxxl)',
                                $fontSizeXxxxl. ' (font-size-xxxx;)',
                                $lineHeightXs. ' (line-height-xs)',
                                $lineHeightSm. ' (line-height-sm)',
                                $lineHeightMd. ' (line-height-md)',
                                $lineHeightLg. ' (line-height-lg)',
                                $lineHeightXl. ' (line-height-xl)',
                                $lineHeightXXl. ' (line-height-xxl)',
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
                    ->merge($this->colors())
            )
            ->render();
    }
}
