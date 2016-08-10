<?php

namespace App\Http\Regions;

use Illuminate\Http\Request;

class ForumItemSmall
{
    public function render(Request $request, $post)
    {
        return component('ForumItemSmall')
            ->with('route', route('content.show', [$post->type, $post]))
            ->with('profile', component('ProfileImage')
                ->with('route', route('user.show', [$post->user]))
                ->with('image', $post->user->imagePreset('small_square'))
                ->with('rank', $post->user->rank * 90)
            )
            ->with('title', $post->title)
            ->with('meta', collect()
                ->push(component('Link')
                    ->with('title', $post->created_at->diffForHumans())
                )
            )
            ->with('badge', component('Badge')->with('title', count($post->comments)));
    }
}
