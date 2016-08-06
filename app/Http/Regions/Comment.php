<?php

namespace App\Http\Regions;

use Illuminate\Http\Request;

class Comment {

    public function render(Request $request, $comment)
    {

        return component('Comment')
            ->with('profile', component('ProfileImage')
                ->with('route', route('user.show', [$comment->user]))
                ->with('image', $comment->user->imagePreset('small_square'))
                ->with('rank', $comment->user->rank * 90)
            )            
            ->with('meta', collect()
                ->push(component('MetaItem')
                    ->with('title', $comment->user->name)
                    ->with('route', route('user.show', [$comment->user]))
                )
                ->push(component('MetaItem')
                    ->with('title', $comment->created_at->diffForHumans())
                )
                ->render()
                ->implode(' ')
            )
            ->with('body', component('Body')->with('body', $comment->body));

    }

}
