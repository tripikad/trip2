<?php

namespace App\Http\Regions;

class About
{
    public function render()
    {
        return component('Block')
                ->with('subtitle', trans('content.action.more.about.text'))
                ->with('content', collect()
                    ->push(component('Link')
                        ->with('title', trans('menu.footer3.about'))
                        ->with('route', config('menu.footer3.about.route'))
                    )
                    ->push(component('Link')
                        ->with('title', trans('menu.footer-social.facebook'))
                        ->with('route', config('menu.footer-social.facebook.route'))
                    )
                    ->push(component('Link')
                        ->with('title', trans('menu.footer-social.twitter'))
                        ->with('route', config('menu.footer-social.twitter.route'))
                    )
                );
    }
}
