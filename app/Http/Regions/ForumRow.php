<?php

namespace App\Http\Regions;

class ForumRow
{
    public function render($forum)
    {
        // $forum = $forum->vars()->isNew($forum);
        $commentCount = $forum->vars()->commentCount;

        return component('ForumRow')
            ->with('route', route('v2.forum.show', [$forum->slug]).($forum->NewCommentId ? '#comment-'.$forum->NewCommentId : ''))
            ->with('user', component('UserImage')
                ->with('route', route('v2.user.show', [$forum->user]))
                ->with('image', $forum->user->imagePreset('small_square'))
                ->with('rank', $forum->user->vars()->rank)
                ->with('size', 48)
                ->with('border', 4)
            )
            ->with('title', $forum->title)
            ->with('meta', component('Meta')->with('items', collect()
                    ->pushWhen($forum->vars()->isNew,
                        component('Tag')->is('red')->with('title', 'isnew: '. $forum->vars()->isNew)
                    )
                    ->pushWhen($forum->vars()->firstUnreadCommentId,
                        component('Tag')->is('red')->with('title', 'id: '.$forum->vars()->firstUnreadCommentId . ' count: '.$forum->vars()->unreadCommentCount)
                    )
                    ->push(component('Badge')
                        ->is($commentCount == 0 ? 'light' : '')
                        ->with('title', $commentCount)
                    )
                    ->push(component('MetaLink')
                        ->with('title', $forum->user->vars()->name)
                        ->with('route', route('v2.user.show', [$forum->user]))
                    )
                    ->push(component('MetaLink')
                        ->with('title', $forum->vars()->created_at)
                    )
                    ->pushWhen($forum->isNew && auth()->user()->hasRole('admin'), component('Tag')->is('red')
                        ->with('title', trans('content.forum.is.new'))
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
