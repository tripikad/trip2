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
            ->with(
                'user',
                'content',
                'content.user',
                'content.comments',
                'content.destinations',
                'flags'
            )
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
                    $photos->count() ? $photos : collect(),
                    collect()
                        ->pushWhen(
                            $photos->count(),
                            component('Button')
                                ->is('transparent')
                                ->with('title', trans('content.photo.more'))
                                ->with('route', route(
                                    'photo.user',
                                    [$user]
                                ))
                        )
                        ->pushWhen(
                            $loggedUser && $user->id == $loggedUser->id,
                            component('Button')
                                ->is($photos->count() ? 'transparent' : 'cyan')
                                ->with('title', trans('content.photo.create.title'))
                                ->with('route', route('photo.create'))
                        )
                )
                : ''
            )

            ->with('content', collect()
                ->pushWhen($comments->count(), component('BlockTitle')
                    ->is('cyan')
                    ->with('title', trans('user.activity.comments.title'))
                )
                ->merge($comments->flatMap(function ($comment) {
                    return collect()
                        ->push(component('Meta')->with('items', collect()
                            ->push(component('MetaLink')
                                ->with('title', trans('user.activity.comments.row.1'))
                            )
                            ->push(component('MetaLink')
                                ->is('cyan')
                                ->with('title', trans('user.activity.comments.row.2'))
                                ->with('route', route('forum.show', [
                                   $comment->content->slug, '#comment-'.$comment->id,
                               ]))
                            )
                            ->push(component('MetaLink')
                                ->with('title', trans('user.activity.comments.row.3'))
                            )
                            ->push(component('MetaLink')
                                ->is('cyan')
                                ->with('title', $comment->content->vars()->title)
                                 ->with('route', route('forum.show', [
                                    $comment->content->slug,
                                ]))
                            )
                        ))
                        ->push(region('Comment', $comment));
                }))
            )

            ->with('footer', region('Footer'))

            ->render();
    }
}
