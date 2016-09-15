<?php

namespace App\Http\Regions;

class ForumRow
{
    public function render($post)
    {
        return component('ForumRow')
            ->with('route', route('forum.show', [$post]))
            ->with('user', component('UserImage')
                ->with('route', route('v2.user.show', [$post->user]))
                ->with('image', $post->user->imagePreset('small_square'))
                ->with('rank', $post->user->vars()->rank)
                ->with('size', 48)
                ->with('border', 4)
            )
            ->with('title', $post->title)
            ->with('meta', component('Meta')->with('items', collect()
                    ->push(component('MetaLink')
                        ->with('title', $post->user->vars()->name)
                        ->with('route', route('user.show', [$post->user]))
                    )
                    ->push(component('MetaLink')
                        ->with('title', $post->vars()->created_at)
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
