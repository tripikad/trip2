<?php

namespace App\Http\Regions;

class UserCard
{
    public function render($post)
    {
        return component('UserCard')
            ->with('image', component('UserImage')
                ->with('route', route('user.show.2', [$post->user]))
                ->with('image', $post->user->imagePreset('small_square'))
                ->with('rank', $post->user->vars()->rank)
                ->with('size', 56)
                ->with('border', 4)
            )
            ->with('name', $post->user->name)
            ->with('route', route('user.show.2', [$post->user]))
            ->with('meta', 'Liitus '.$post->user->vars()->created_at_relative);
    }
}
