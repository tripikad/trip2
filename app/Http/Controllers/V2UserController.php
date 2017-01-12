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
        $loggedUser = request()->user();

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

            ->with('top',
                $photos->count() || ($loggedUser && $user->id == $loggedUser->id)
                ? region('Gallery', $photos, collect()
                    ->pushWhen(
                        $loggedUser && $user->id == $loggedUser->id,
                        component('Button')
                            ->is('cyan')
                            ->with('title', trans('content.photo.create.title'))
                            ->with('route', route('content.create', ['photo']))
                            ->render()
                    )
                )
                : ''
            )

            /*
                $loggedUser && $loggedUser->hasRole('regular')
                ? [component('Button')
                    ->is($is)
                    ->with('title', trans('content.photo.create.title'))
                    ->with('route', route('content.create', ['photo']))
                    ->render()]
                : ''
            */

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
