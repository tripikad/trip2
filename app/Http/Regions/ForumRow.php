<?php

namespace App\Http\Regions;

class ForumRow
{
    public function render($forum)
    {
        $forum = $forum->vars()->isNew($forum);

        if (isset($forum->route)) {
            $count = $forum->comments->filter(function ($comment) use ($forum) {
                return  $comment->id >= $forum->route;
            })->count();
        }


        return component('ForumRow')
            ->with('route', route('v2.forum.show', [$forum->slug]).($forum->isNew ? '#'.$forum->route : ''))
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
                    ->pushWhen($forum->isNew, component('MetaLink')
                        ->with('title', 'uus')
                        )
                    ->pushWhen(isset($count), component('MetaLink')
                        ->with('title', 'uus komm '.(isset($count) ? $count : ''))
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
