<?php

namespace App\Http\Regions;

class ForumRow
{
    public function render($forum, $route = '')
    {
        $user = request()->user();
        $commentCount = $forum->vars()->commentCount;
        $unreadCommentCount = $forum->vars()->unreadCommentCount;
        $firstUnreadCommentId = $forum->vars()->firstUnreadCommentId;
        $route = $route ? $route : route('forum.show', [$forum->slug]);

        return component('ForumRow')
            ->with('route', $route)
            ->with('user', component('UserImage')
                ->with('route', route('user.show', [$forum->user]))
                ->with('image', $forum->user->vars()->imagePreset('small_square'))
                ->with('rank', $forum->user->vars()->rank)
                ->with('size', 58)
                ->with('border', 3)
            )
            ->with('title', $forum->vars()->title)
            ->with('meta', component('Meta')->with('items', collect()
                    ->pushWhen($user && $user->hasRole('regular') && $forum->vars()->isNew,
                        component('Tag')
                            ->is('red')
                            ->with('title', trans('content.show.isnew'))
                            ->with('route', $route)
                    )
                    ->pushWhen($user && $user->hasRole('regular') && $firstUnreadCommentId,
                        component('Tag')
                            ->is('red')
                            ->with('title', trans_choice(
                                'content.show.newcomments',
                                $unreadCommentCount,
                                ['count' => $unreadCommentCount]
                            ))
                            ->with('route', route(
                                'forum.show',
                                [$forum->slug]).'#comment-'.$firstUnreadCommentId
                            )
                    )
                    ->pushWhen($commentCount, component('Tag')
                        ->with('title', $commentCount)
                    )
                    ->push(component('MetaLink')
                        ->is('cyan')
                        ->with('title', $forum->user->vars()->name)
                        ->with('route', route('user.show', [$forum->user]))
                    )
                    ->push(component('MetaLink')
                        ->is('gray')
                        ->with('title', $forum->vars()->updated_at)
                    )
                    ->merge($forum->destinations->map(function ($destination) {
                        return component('Tag')
                            ->is('orange')
                            ->with('title', $destination->name)
                            ->with('route', route('destination.show', [$destination]));
                    }))
                    ->merge($forum->topics->map(function ($topic) {
                        return component('MetaLink')
                            ->with('title', $topic->name)
                            ->with('route', route('forum.index', ['topic' => $topic]));
                    }))
                )
            );
    }
}
