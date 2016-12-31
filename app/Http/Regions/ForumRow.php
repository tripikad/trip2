<?php

namespace App\Http\Regions;

class ForumRow
{
    public function render($forum)
    {
        $user = request()->user();
        $commentCount = $forum->vars()->commentCount;
        $unreadCommentCount = $forum->vars()->unreadCommentCount;
        $firstUnreadCommentId = $forum->vars()->firstUnreadCommentId;

        return component('ForumRow')
            ->with('route', route('v2.forum.show', [$forum->slug]))
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
                        ->with('route', route('v2.user.show', [$forum->user]))
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
                    ->merge($forum->topics->map(function ($destination) {
                        return component('MetaLink')->with('title', $destination->name);
                    }))
                )
            );
    }
}
