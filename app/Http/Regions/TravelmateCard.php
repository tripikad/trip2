<?php

namespace App\Http\Regions;

class TravelmateCard
{
    public function render($travelmate, $tagLimit = 4)
    {
        return component('TravelmateCard')
            ->with('user', component('UserImage')
                ->with('route', route('user.show', [$travelmate->user]))
                ->with('image', $travelmate->user->imagePreset('small_square'))
                ->with('rank', $travelmate->user->vars()->rank)
                ->with('size', 74)
                ->with('border', 3)
            )
            ->with('route', route('travelmate.show', [$travelmate->slug]))
            ->with('title', $travelmate->vars()->shortTitle)
            ->with('meta_bottom', component('Meta')->with('items', collect()
                ->push(component('MetaLink')
                    ->is('cyan')
                    ->with('title', $travelmate->user->vars()->name)
                    ->with('route', route('user.show', [$travelmate->user]))
                )
                ->merge($travelmate->destinations->take($tagLimit)
                    ->map(function ($destination) {
                        return component('Tag')
                            ->is('orange')
                            ->with('title', $destination->name)
                            ->with('route', route('destination.showSlug', [$destination->slug]));
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
