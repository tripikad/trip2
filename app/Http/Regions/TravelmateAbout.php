<?php

namespace App\Http\Regions;

class TravelmateAbout
{
    public function render()
    {
        $type = 'travelmate';
        $user = auth()->user();

        return component('Block')
            ->is('dark')
            ->with('title', trans('content.travelmate.description.title'))
            ->with('content', collect()
                ->push(component('Body')
                    ->with('body', trans('content.travelmate.description.text'))
                )
                ->push(component('Link')
                    ->with('title', trans('content.travelmate.index.eula.title'))
                    ->with('route', route('v2.static.show', [25151]))
                )
                ->pushWhen($user && $user->hasRole('admin'), component('Button')
                    ->with('title', trans("content.$type.create.title"))
                    ->with('route', route('content.create', [$type]))
                )
            );
    }
}
