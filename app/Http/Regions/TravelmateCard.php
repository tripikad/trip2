<?php

namespace App\Http\Regions;

class TravelmateCard
{
    public function render($travelmate, $tagLimit = 4)
    {
        return component('TravelmateCard')
            ->with('user', component('UserImage')
                ->with('route', route('v2.user.show', [$travelmate->user]))
                ->with('image', $travelmate->user->imagePreset('small_square'))
                ->with('rank', $travelmate->user->vars()->rank)
                ->with('size', 72)
                ->with('border', 4)
            )
            ->with('route', route('v2.travelmate.show', [$travelmate->slug]))
            ->with('meta_top', component('Meta')->with('items', collect()
                ->push(component('MetaLink')
                    ->with('title', $travelmate->user->vars()->name)
                    ->with('route', route('v2.user.show', [$travelmate->user]))
                ))
            )
            ->with('title', $travelmate->vars()->shortTitle)
            ->with('meta_bottom', component('Meta')->with('items', collect()
                ->merge($travelmate->destinations->take($tagLimit)
                    ->map(function ($destination) {
                        return component('Tag')
                            ->is('orange')
                            ->with('title', $destination->name)
                            ->with('route', route('v2.destination.show', [$destination]));
                    }))
                ->pushWhen(
                    $travelmate->destinations->count() > $tagLimit,
                    component('Tag')
                        ->is('orange')
                        ->with('title', '...')
                )
                ->merge($travelmate->topics->take($tagLimit)
                    ->map(function ($topic) {
                        return component('MetaLink')
                            ->with('title', $topic->name);
                    })
                )
                ->pushWhen(
                    $travelmate->topics->count() > $tagLimit,
                    component('MetaLink')
                        ->with('title', '...')
                )

            )
        );
    }
}
