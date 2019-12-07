<?php

namespace App\Http\Regions;

class StyleguideMenu
{
    public function render()
    {
        return component('Flex')->with(
            'items',
            collect()->merge(
                collect(config('styleguide'))->map(function ($link) {
                    return component('Title')
                        ->is('blue')
                        ->is('smallest')
                        ->with('title', $link['title'])
                        ->with('route', route($link['route'], array_key_exists('preview', $link) ? ['preview'] : null));
                })
            )
        );
    }
}
