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
                    ->with('title', trans('content.action.more.about'))
                    ->with('route', route('v2.static.show', [1534]))
                )
                ->push(component('Link')
                    ->with('title', trans('content.action.price.error'))
                    ->with('route', route('v2.static.show', [97203]))
                )
                ->pushWhen($user && $user->hasRole('admin'), component('Button')
                    ->with('title', trans("content.$type.create.title"))
                    ->with('route', route('content.create', [$type]))
                )
            );
    }
}
