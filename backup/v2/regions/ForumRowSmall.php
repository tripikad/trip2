<?php

namespace App\Http\Regions;

class ForumRowSmall
{
    public function render($forum)
    {
        return component('ForumRowSmall')
            ->with('route', route('forum.show', [$forum]))
            ->with('user', component('UserImage')
                ->with('route', route('user.show', [$forum->user]))
                ->with('image', $forum->user->imagePreset('small_square'))
                ->with('rank', $forum->user->vars()->rank)
            )
            ->with('title', $forum->vars()->shortTitle)
            ->with('meta', component('Meta')->with('items', collect()
                    ->push(component('Badge')->with('title', $forum->vars()->commentCount))
                    ->push(component('MetaLink')
                        ->with('title', $forum->vars()->created_at)
                    )
                )
            );
    }
}
