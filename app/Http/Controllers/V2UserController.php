<?php

namespace App\Http\Controllers;

use App\User;
use App\Image;
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

            ->with('title', $user->vars()->name())
            ->with('head_title', $user->vars()->name())
            ->with(
                'head_description',
                trans("user.rank.$user->rank")
                .trans('user.show.about.joined', [
                    'created_at' => $user->vars()->created_at_relative,
                ])
            )
            ->with('head_image', Image::getSocial())

            ->with('header', region('UserHeader', $user))

            ->with('top',
                $photos->count() || ($loggedUser && $user->id == $loggedUser->id)
                ? region(
                    'PhotoRow',
                    $photos,
                    collect()
                        ->push(
                            component('Button')
                                ->is('transparent')
                                ->with('title', trans('content.photo.more'))
                                ->with('route', route(
                                    'v2.photo.user',
                                    [$user]
                                ))
                        )
                        ->pushWhen(
                            $loggedUser && $user->id == $loggedUser->id,
                            component('Button')
                                ->is('transparent')
                                ->with('title', trans('content.photo.create.title'))
                                ->with('route', route('content.create', ['photo']))
                        )
                )
                : ''
            )

            ->with('content', $comments->map(function ($comment) {
                return component('UserCommentRow')
                        ->with('forum', region('ForumRow', $comment->content))
                        ->with('comment', region('Comment', $comment));
            }))

            ->with('footer', region('Footer'))

            ->render();
    }
}
