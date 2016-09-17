<?php

namespace App\Http\Regions;

class ForumRow
{
    public function render($forum)
    {
        return component('ForumRow')
            ->with('route', route('v2.forum.show', [$forum->slug]))
            ->with('user', component('UserImage')
                ->with('route', route('v2.user.show', [$forum->user]))
                ->with('image', $forum->user->imagePreset('small_square'))
                ->with('rank', $forum->user->vars()->rank)
                ->with('size', 48)
                ->with('border', 4)
            )
            ->with('title', $forum->title)
            ->with('meta', component('Meta')->with('items', collect()
                    ->push(component('MetaLink')
                        ->with('title', $forum->user->vars()->name)
                        ->with('route', route('v2.user.show', [$forum->user]))
                    )
                    ->push(component('MetaLink')
                        ->with('title', $forum->vars()->created_at)
                    )
                    ->merge($forum->destinations->map(function ($tag) {
                        return component('Tag')->is('orange')->with('title', $tag->name);
                    }))
                    ->merge($forum->topics->map(function ($tag) {
                        return component('Tag')->with('title', $tag->name);
                    }))
                )
            );
    }
}
