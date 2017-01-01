<?php

namespace App\Http\Controllers;

use Cache;
use App\Content;

class V2AdminController extends Controller
{
    public function index()
    {
        $forums = Content::getLatestPagedItems('internal', false, false, false, 'updated_at');

        return layout('2col')

            ->with('header', region(
                'HeaderLight',
                trans('content.internal.index.title')
            ))

            ->with('content', collect()
                ->merge($forums->map(function ($forum) {
                    return region('ForumRow', $forum, route('v2.internal.show', [$forum]));
                }))
                ->push(region('Paginator', $forums))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function show($slug)
    {
        $forum = Content::findOrFail($slug);
        $user = auth()->user();
        $firstUnreadCommentId = $forum->vars()->firstUnreadCommentId;

        // Clear the unread cache

        if ($user) {
            $key = 'new_'.$forum->id.'_'.$user->id;
            Cache::forget($key);
        }

        return layout('2col')

            ->with('header', region(
                'HeaderLight',
                trans('content.internal.index.title')
            ))

            ->with('content', collect()
                ->push(region('ForumPost', $forum))
                ->merge($forum->comments->map(function ($comment) use ($firstUnreadCommentId) {
                    return region('Comment', $comment, $firstUnreadCommentId);
                }))
                ->pushWhen($user && $user->hasRole('regular'), region('CommentCreateForm', $forum))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }
}
