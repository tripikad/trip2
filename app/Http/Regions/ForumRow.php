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
        $route = $route ? $route : route('v2.forum.show', [$forum->slug]);

        return component('ForumRow')
            ->with('route', $route)
            ->with('user', component('UserImage')
                ->with('route', route('v2.user.show', [$forum->user]))
                ->with('image', $forum->user->vars()->imagePreset('small_square'))
                ->with('rank', $forum->user->vars()->rank)
                ->with('size', 58)
                ->with('border', 4)
            )
            ->with('title', $forum->title)
            ->with('meta', component('Meta')->with('items', collect()
                    ->pushWhen($user && $user->hasRole('admin') && $forum->vars()->isNew,
                        component('Tag')
                            ->is('red')
                            ->with('title', trans('content.show.isnew'))
                            ->with('route', $route)
                    )
                    ->pushWhen($user && $user->hasRole('admin') && $firstUnreadCommentId,
                        component('Tag')
                            ->is('red')
                            ->with('title', trans_choice(
                                'content.show.newcomments',
                                $unreadCommentCount,
                                ['count' => $unreadCommentCount]
                            ))
                            ->with('route', route(
                                'v2.forum.show',
                                [$forum->slug]).'#comment-'.$firstUnreadCommentId
                            )
                    )
                    ->push(component('Tag')
                        ->is($commentCount == 0 ? 'light' : '')
                        ->with('title', $commentCount)
                    )
                    ->push(component('MetaLink')
                        ->with('title', $forum->user->vars()->name)
                    )
                    ->push(component('MetaLink')
                        ->with('title', $forum->vars()->created_at)
                    )
                    ->merge($forum->destinations->map(function ($destination) {
                        return component('Tag')
                            ->is('orange')
                            ->with('title', $destination->name)
                            ->with('route', route('v2.destination.show', [$destination]));
                    }))
                    ->merge($forum->topics->map(function ($topic) {
                        return component('MetaLink')->with('title', $topic->name);
                    }))
                )
            );
    }
}
