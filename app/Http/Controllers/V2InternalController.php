<?php

namespace App\Http\Controllers;

use App;
use Cache;
use App\Content;

class V2InternalController extends Controller
{
    public function index()
    {
        $forums = Content::getLatestPagedItems('internal', false, false, false, 'updated_at');

        $loggedUser = request()->user();

        return layout('1col')

            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->with('title', trans('content.internal.index.title'))
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('AdminLinks'))
                )
                ->pushWhen(
                    $loggedUser && $loggedUser->hasRole('admin'),
                    component('Button')
                        ->is('narrow')
                        ->with('title', trans('content.internal.create.title'))
                        ->with('route', route('internal.create'))
                )
            ))

            ->with('content', collect()
                ->merge($forums->map(function ($forum) {
                    return region('ForumRow', $forum, route('internal.show', [$forum]));
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
            Cache::store('permanent')->forget($key);
        }

        return layout('1col')

            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->with('title', trans('content.internal.index.title'))
                    ->with('route', route('internal.index'))
                )
            ))

            ->with('content', collect()
                ->push(region('ForumPost', $forum))
                ->merge($forum->comments->map(function ($comment) use ($firstUnreadCommentId) {
                    return region('Comment', $comment, $firstUnreadCommentId, 'inset');
                }))
                ->pushWhen($user && $user->hasRole('regular'), region('CommentCreateForm', $forum, 'inset'))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function create()
    {
        return App::make('App\Http\Controllers\ContentController')
            ->create('internal');
    }

    public function edit($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->edit('internal', $id);
    }

    public function store()
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'internal');
    }

    public function update($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'internal', $id);
    }
}
