<?php

namespace App\Http\Controllers\Styleguide;

use App\Http\Controllers\Controller;

class FontsController extends Controller
{
    public function index()
    {
        return layout('Two')
            ->with('title', 'Styles')
            ->with(
                'content',
                collect()
                    ->push(region('StyleguideMenu'))
                    ->push(component('Title')->with('title', 'Fonts'))
                    ->merge($this->fonts())
            )
            ->render();
    }

    public function fonts()
    {
        return collect(styles())
            ->filter(function ($value, $key) {
                return starts_with($key, [
                    'font-text',
                    'font-heading',
                    'font-code'
                ]);
            })
            ->map(function ($value, $key) {
                return component('StyleFont')
                    ->with('value', $value)
                    ->with('key', $key);
            });
    }
}
