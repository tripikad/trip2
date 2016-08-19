<?php

namespace App\Http\Regions;

class TravelmateCard {

    public function render($post)
    {

        return component('TravelmateCard')
            ->with('ProfileImage', component('ProfileImage')
                ->with('route', route('user.show', [$post->user]))
                ->with('image', $post->user->imagePreset('small_square'))
                ->with('rank', $post->user->vars()->rank)
                ->with('size', 86)
                ->with('border', 4))
            ->with('user', $post->user->name)
            ->with('title', $post->title)
            ->with('meta', component('Meta')->with('items', collect()
                ->merge($post->destinations->map(function ($tag) {
                    return component('Tag')->is('orange')->with('title', $tag->name);
                }))
                ->merge($post->topics->map(function ($tag) {
                    return component('Tag')->with('title', $tag->name);
                }))
                )
            );

    }

}
