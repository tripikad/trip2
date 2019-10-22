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
                        str_replace('$spacer', $spacer, $value)
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
            ->dump()
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
                            ->with('title', 'Spacings')
                    )
                    ->merge($this->spacings())
                    ->push(
                        component('Title')
                            ->is('small')
                            ->with('title', 'Widths')
                    )
                    ->merge($this->widths())
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
