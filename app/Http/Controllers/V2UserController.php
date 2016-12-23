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

        $comments = $user->comments()
            ->with(['content', 'content.user'])
            ->whereStatus(1)
            ->whereHas('content', function ($query) use ($types) {
                $query->whereIn('type', $types);
            })
            ->latest()
            ->take(10)
            ->get();

        return view('v2.layouts.1col')

            ->with('header', region('UserHeader', $user))

            ->with('content', $comments->map(function ($comment) {
                    return component('UserCommentBlock')
                        ->with('forum', region('ForumRow', $comment->content))
                        ->with('comment', region('Comment', $comment));
                        
                })
            )

            ->with('footer', region('Footer'));
    }
}
