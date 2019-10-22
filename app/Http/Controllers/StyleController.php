<?php

namespace App\Http\Controllers;

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
                    ->merge($this->spacings())
                    ->merge($this->colors())
            )
            ->render();
    }
}
