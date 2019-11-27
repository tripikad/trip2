<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Support\Facades\Storage;

class ExperimentsFontsController extends Controller
{
    public function index()
    {
        return layout('Two')
            ->with('title', 'Styles')
            ->with(
                'content',
                collect()
                    ->push(region('ExperimentalMenu'))
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
