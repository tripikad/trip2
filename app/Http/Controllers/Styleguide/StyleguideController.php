<?php

namespace App\Http\Controllers\Styleguide;

use App\Http\Controllers\Controller;

class StyleguideController extends Controller
{
    public function index()
    {
        return layout('Two')
      ->with(
        'content',
        collect(config('styleguide'))->map(function ($link, $key) {
            return component('Title')
            ->is($key > 0 ? 'blue' : '')
            ->is($key > 0 ? 'small' : '')
            ->with('title', $link['title'])
            ->with('route', route($link['route'], array_key_exists('preview', $link) ? ['preview'] : null));
        })
      )

      ->render();
    }
}
