<?php

namespace App\Http\Regions;

class ForumItem
{
    public function render($post)
    {
        return component('ForumItem')
            ->with('route', route('content.show', [$post->type, $post]))
            ->with('profile', component('ProfileImage')
                ->with('route', route('user.show', [$post->user]))
                ->with('image', $post->user->imagePreset('small_square'))
                ->with('rank', $post->user->vars()->rank)
                ->with('size', 48)
                ->with('border', 4)
            )
            ->with('title', $post->title)
            ->with('meta', component('Meta')->with('items', collect()
                    ->push(component('Link')
                        ->with('title', $post->user->vars()->name)
                        ->with('route', route('user.show', [$post->user]))
                    )
                    ->push(component('Link')
                        ->with('title', $post->created_at->diffForHumans())
                    )
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
