<?php

namespace App\Http\Regions;

class ForumRowSmall
{
    public function render($post)
    {
        return component('ForumRowSmall')
            ->with('route', route('content.show', [$post->type, $post]))
            ->with('profile', component('ProfileImage')
                ->with('route', route('user.show', [$post->user]))
                ->with('image', $post->user->imagePreset('small_square'))
                ->with('rank', $post->user->vars()->rank)
            )
            ->with('title', $post->title)
            ->with('meta', component('Meta')->with('items', collect()
                    ->push(component('MetaLink')
                        ->with('title', $post->vars()->created_at)
                    )
                )
            )
            ->with('badge', component('Badge')->with('title', count($post->comments)));
    }
}
