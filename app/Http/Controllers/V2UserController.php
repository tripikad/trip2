<?php

namespace App\Http\Controllers;

use App\User;
use App\Content;

class V2UserController extends Controller
{
    public function show($id)
    {
        $types = ['forum', 'travelmate', 'buysell'];

        $user = User::findOrFail($id);

        $photos = $user
            ->contents()
            ->whereType('photo')
            ->whereStatus(1)
            ->take(9)
            ->latest()
            ->get();

        $comments = $user->comments()
            ->with(['content', 'content.user'])
            ->whereStatus(1)
            ->whereHas('content', function ($query) use ($types) {
                $query->whereIn('type', $types);
            })
            ->latest()
            ->take(24)
            ->get();

        return layout('1col')

            ->with('header', region('UserHeader', $user))

            ->with('top', $photos->count() ? region('Gallery', $photos) : '')

            ->with('content', $comments->map(function ($comment) {
                return component('UserCommentRow')
                        ->with('forum', region('ForumRow', $comment->content))
                        ->with('comment', region('Comment', $comment));
            })
            )

            ->with('footer', region('Footer'))

            ->render();
    }
}
