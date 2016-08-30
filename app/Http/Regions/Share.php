<?php

namespace App\Http\Regions;

use URL;

class Share
{
    public function render()
    {
        return component('Grid2')
            ->with('gutter', true)
            ->with('items', collect()
                 ->push(component('Button')
                    ->is('facebook')
                    ->with('external', true)
                    ->with('icon', 'icon-facebook')
                    ->with('title', trans('utils.share.facebook'))
                    ->with('route', route('utils.share', ['facebook']))
                )
                ->push(component('Button')
                    ->is('twitter')
                    ->with('external', true)
                    ->with('icon', 'icon-twitter')
                    ->with('title', trans('utils.share.twitter'))
                    ->with('route', route('utils.share', ['twitter']))
                ));
    }
}
