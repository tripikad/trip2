<?php

namespace App\Http\Regions;

class UserCard
{
    public function render($post)
    {
        return component('UserCard')
            ->with('profile', component('UserImage')
                ->with('route', route('user.show.2', [$post->user]))
                ->with('image', $post->user->imagePreset('small_square'))
                ->with('rank', $post->user->vars()->rank)
                ->with('size', 56)
                ->with('border', 4)
            )
            ->with('meta', component('Meta')->with('items', collect()
                    ->push(component('MetaLink')
                        ->with('title', $post->user->vars()->name)
                        ->with('route', route('user.show', [$post->user]))
                    )
                )
            );
    }
}
