<?php

namespace App\Http\Controllers;

use App\Content;

class V2InternalController extends Controller
{
    public function index()
    {
        $forums = Content::getLatestPagedItems('internal', false, false, false, 'updated_at');

        $loggedUser = request()->user();

        $navBar = collect()->pushWhen(
            $loggedUser && $loggedUser->hasRole('admin'),
            component('Button')
                ->is('narrow')
                ->with('title', trans('content.internal.create.title'))
                ->with('route', route('internal.create'))
        )
            ->pushWhen($loggedUser && $loggedUser->hasRole('admin'), component('Link')
                ->with('title', trans('menu.admin.image'))
                ->with('route', route('admin.image.index'))
            )
            ->pushWhen($loggedUser && $loggedUser->hasRole('admin'), component('Link')
                ->with('title', trans('menu.admin.content'))
                ->with('route', route('admin.content.index'))
            )
            ->pushWhen($loggedUser && $loggedUser->hasRole('admin'), component('Link')
                ->with('title', trans('menu.admin.poll'))
                ->with('route', route('poll.index'))
            );

        if ($loggedUser && $loggedUser->hasRole('superuser')) {
            $static_contents = Content::select('id', 'title')->whereType('static')->get();
            foreach ($static_contents as &$static_content) {
                $navBar->push(component('Link')
                    ->with('title', trans('menu.admin.static', ['title' => $static_content->title]))
                    ->with('route', route('static.edit', [$static_content->id]))
                );
            }

            $navBar->push(component('Link')
                ->with('title', trans('menu.admin.newsletter'))
                ->with('route', route('newsletter.index'))
            );
        }

        return layout('2col')

            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')

            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->with('title', trans('content.internal.index.title'))
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
            ))

            ->with('content', collect()
                ->merge($forums->map(function ($forum) {
                    return region('ForumRow', $forum, route('internal.show', [$forum]));
                }))
                ->push(region('Paginator', $forums))
            )

            ->with('sidebar', $navBar)

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function show($slug)
    {
        $loggedUser = auth()->user();
        $forum = Content::findOrFail($slug);

        $firstUnreadCommentId = $forum->vars()->firstUnreadCommentId;

        return layout('2col')

            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')

            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->with('title', trans('content.internal.index.title'))
                )
            ))

            ->with('content', collect()
                ->push(region('ForumPost', $forum, 'internal.edit'))
                ->merge($forum->comments->map(function ($comment) use ($firstUnreadCommentId) {
                    return region('Comment', $comment, $firstUnreadCommentId, 'inset');
                }))
                ->pushWhen($loggedUser && $loggedUser->hasRole('regular'), region('CommentCreateForm', $forum, 'inset'))
            )

            ->with('sidebar', collect()
                ->pushWhen(
                    $loggedUser && $loggedUser->hasRole('admin'),
                    component('Button')
                        ->is('narrow')
                        ->with('title', trans('content.internal.create.title'))
                        ->with('route', route('internal.create'))
                )
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function create()
    {
        return layout('1col')

            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')

            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->is('gray')
                    ->with('title', trans('content.internal.index.title'))
                    ->with('route', route('internal.index'))
                )
            ))

            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('content.internal.create.title'))
                )
                ->push(component('Form')
                    ->with('route', route('internal.store'))
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', trans('content.internal.edit.field.title.title'))
                            ->with('name', 'title')
                            ->with('value', old('title'))
                        )
                        ->push(component('FormTextarea')
                            ->with('title', trans('content.internal.edit.field.body.title'))
                            ->with('name', 'body')
                            ->with('value', old('title'))
                            ->with('rows', 10)
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('content.create.submit.title'))
                        )
                    )
                )
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function store()
    {
        $loggedUser = request()->user();

        $rules = [
            'title' => 'required',
            'body' => 'required',
        ];

        $this->validate(request(), $rules);

        $internal = $loggedUser->contents()->create([
            'title' => request()->title,
            'body' => request()->body,
            'type' => 'internal',
            'status' => '1',
        ]);

        return redirect()
            ->route('internal.index')
            ->with('info', trans('content.store.info', [
                'title' => $internal->title,
            ]));
    }

    public function edit($id)
    {
        $internal = Content::findOrFail($id);

        return layout('1col')

            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')

            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->is('gray')
                    ->with('title', trans('content.internal.index.title'))
                    ->with('route', route('internal.index'))
                )
            ))

            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('content.internal.edit.title'))
                )
                ->push(component('Form')
                    ->with('route', route('internal.update', [$internal]))
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', trans('content.blog.edit.field.title.title'))
                            ->with('name', 'title')
                            ->with('value', old('title', $internal->title))
                        )
                        ->push(component('FormTextarea')
                            ->with('title', trans('content.internal.edit.field.body.title'))
                            ->with('name', 'body')
                            ->with('value', old('body', $internal->body))
                            ->with('rows', 10)
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('content.edit.submit.title'))
                        )
                    )
                )
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function update($id)
    {
        $internal = Content::findOrFail($id);

        $rules = [
            'title' => 'required',
            'body' => 'required',
        ];

        $this->validate(request(), $rules);

        $internal->update([
            'title' => request()->title,
            'body' => request()->body,
        ]);

        return redirect()
            ->route('internal.show', [$internal])
            ->with('info', trans('content.update.info', [
                'title' => $internal->title,
            ]));
    }
}
