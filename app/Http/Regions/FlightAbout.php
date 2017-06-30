<?php

namespace App\Http\Regions;

class FlightAbout
{
    public function render()
    {
        $type = 'flight';
        $user = auth()->user();

        return component('Block')
            ->with('content', collect()
                ->push(component('Body')
                    ->with('body', trans("site.description.$type"))
                )
                ->push(component('Link')
                    ->is('blue')
                    ->with('title', trans('content.action.more.about'))
                    ->with('route', route('static.show', 'tripist'))
                )
                ->push(component('Link')
                    ->is('blue')
                    ->with('title', trans('content.action.price.error'))
                    ->with('route', route('static.show', 'mis-on-veahind'))
                )
                ->pushWhen($user && $user->hasRole('admin'), component('Button')
                    ->with('title', trans("content.$type.create.title"))
                    ->with('route', route("$type.create"))
                )
                ->pushWhen($user && $user->hasRole('admin'), component('Button')
                    ->with('title', trans("content.$type.create.title")." 2")
                    ->with('route', route("$type.create2"))
                )
            );
    }
}
