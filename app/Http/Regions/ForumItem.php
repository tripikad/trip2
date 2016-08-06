<?php

namespace App\Http\Regions;

use Illuminate\Http\Request;

class ForumItem {

    public function render(Request $request, $post)
    {

        return component('ForumItem')
            ->with('profile', component('ProfileImage')
                ->with('image', $post->user->imagePreset('small_square'))
                ->with('value', $post->user->rank * 90)
                ->with('route', route('user.show', [$post->user]))
            )            
            ->with('title', $post->title)
            ->with('route', route('content.show', [$post->type, $post]))
            ->with('meta', collect()
                ->push(component('MetaItem')
                    ->with('title', $post->user->name)
                    ->with('route', route('user.show', [$post->user]))
                )
                ->push(component('MetaItem')
                    ->with('title', $post->created_at->diffForHumans())
                )
                ->merge($post->destinations->map(function($tag) {
                    return component('Tag')->is('orange')->with('title', $tag->name);
                }))
                ->merge($post->topics->map(function($tag) {
                    return component('Tag')->with('title', $tag->name);
                }))
                ->render()
                ->implode(' ')
            );

    }

}
