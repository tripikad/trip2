<?php

namespace App\Http\Controllers;

use Log;
use App\Content;
use App\Destination;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Content::getLatestPagedItems('blog', 10);
        $loggedUser = request()->user();

        return layout('Two')
            ->with(
                'header',
                region(
                    'Header',
                    collect()->push(
                        component('Title')
                            ->is('white')
                            ->is('large')
                            ->with('title', trans('content.blog.index.title'))
                            ->with('route', route('blog.index'))
                    )
                )
            )

            ->with(
                'content',
                collect()
                    ->merge(
                        $blogs->flatMap(function ($blog) {
                            return collect()
                                ->push(region('BlogRow', $blog))
                                ->push(
                                    component('Body')
                                        ->is('responsive')
                                        ->with('body', $blog->vars()->body)
                                );
                        })
                    )
                    ->push(region('Paginator', $blogs))
            )

            ->with(
                'sidebar',
                collect()
                    ->pushWhen(
                        $loggedUser && $loggedUser->hasRole('regular'),
                        component('Button')
                            ->with('title', trans('content.blog.create.title'))
                            ->with('route', route('blog.create'))
                    )
                    ->push(component('Promo')->with('promo', 'sidebar_small'))
                    //->push(component('Promo')->with('promo', 'sidebar_large'))
                    ->push(component('Promo')->with('promo', 'sidebar_large'))
                    //->push(component('Promo')->with('promo', 'mobile_big')->is('mobile-only'))
            )

            ->with('bottom', collect()->push(component('Promo')->with('promo', 'footer')))

            ->with('footer', region('Footer'))

            ->render();
    }

    public function show($slug)
    {
        $user = auth()->user();
        $blog = Content::getItemBySlug($slug, $user);

        return layout('Two')
            ->with(
                'header',
                region(
                    'Header',
                    collect()
                        ->push(
                            component('Link')
                                ->is('white')
                                ->is('large')
                                ->with('title', trans('content.blog.show.action.all'))
                                ->with('route', route('blog.index'))
                        )
                        ->push(
                            component('Title')
                                ->is('white')
                                ->is('large')
                                ->with('title', trans('content.blog.index.title'))
                                ->with('route', route('blog.index'))
                        )
                )
            )

            ->with(
                'top',
                collect()->pushWhen(
                    !$blog->status,
                    component('HeaderUnpublished')->with('title', trans('content.show.unpublished'))
                )
            )

            ->with(
                'content',
                collect()
                    ->push(region('BlogRow', $blog))
                    ->push(
                        component('Body')
                            ->is('responsive')
                            ->with('body', $blog->vars()->body)
                    )
                    ->merge(
                        $blog->comments->map(function ($comment) {
                            return region('Comment', $comment);
                        })
                    )
                    ->pushWhen($user && $user->hasRole('regular'), region('CommentCreateForm', $blog))
            )

            ->with(
                'sidebar',
                collect()
                    ->push(component('Promo')->with('promo', 'sidebar_small'))
                    //->push(component('Promo')->with('promo', 'sidebar_large'))
                    ->push(component('Promo')->with('promo', 'sidebar_large'))
                    //->push(component('Promo')->with('promo', 'mobile_big')->is('mobile-only'))
            )

            ->with('bottom', collect()->push(component('Promo')->with('promo', 'footer')))

            ->with('footer', region('Footer'))

            ->render();
    }

    public function create()
    {
        $destinations = Destination::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        return layout('Two')
            ->with(
                'header',
                region(
                    'Header',
                    collect()->push(
                        component('Title')
                            ->is('white')
                            ->is('large')
                            ->with('title', trans('content.blog.index.title'))
                            ->with('route', route('blog.index'))
                    )
                )
            )

            ->with(
                'content',
                collect()
                    ->push(component('Title')->with('title', trans('content.blog.create.title')))
                    ->push(
                        component('Form')
                            ->with('route', route('blog.store'))
                            ->with(
                                'fields',
                                collect()
                                    ->push(
                                        component('FormTextfield')
                                            ->is('large')
                                            ->with('title', trans('content.blog.edit.field.title.title'))
                                            ->with('name', 'title')
                                            ->with('value', old('title'))
                                    )
                                    ->push(
                                        component('FormTextarea')
                                            ->with('title', trans('content.blog.edit.field.body.title'))
                                            ->with('name', 'body')
                                            ->with('value', old('title'))
                                            ->with('rows', 20)
                                    )
                                    ->push(
                                        component('FormSelectMultiple')
                                            ->with('name', 'destinations')
                                            ->with('options', $destinations)
                                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
                                    )
                                    ->push(component('FormButton')->with('title', trans('content.create.submit.title')))
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
            'body' => 'required'
        ];

        $this->validate(request(), $rules);

        $blog = $loggedUser->contents()->create([
            'title' => request()->title,
            'body' => request()->body,
            'type' => 'blog',
            'status' => 1
        ]);

        $blog->destinations()->attach(request()->destinations);

        Log::info('New content added', [
            'user' => $blog->user->name,
            'title' => $blog->title,
            'type' => $blog->type,
            'body' => $blog->body,
            'link' => route('blog.show', [$blog->slug])
        ]);

        return redirect()
            ->route('blog.index')
            ->with(
                'info',
                trans('content.store.info', [
                    'title' => $blog->title
                ])
            );
    }

    public function edit($id)
    {
        $blog = Content::findOrFail($id);
        $destinations = Destination::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        return layout('Two')
            ->with(
                'header',
                region(
                    'Header',
                    collect()->push(
                        component('Title')
                            ->is('white')
                            ->is('large')
                            ->with('title', trans('content.blog.index.title'))
                            ->with('route', route('blog.index'))
                    )
                )
            )

            ->with(
                'content',
                collect()
                    ->push(component('Title')->with('title', trans('content.blog.update.title')))
                    ->push(
                        component('Form')
                            ->with('route', route('blog.update', [$blog]))
                            ->with('method', 'PUT')
                            ->with(
                                'fields',
                                collect()
                                    ->push(
                                        component('FormTextfield')
                                            ->is('large')
                                            ->with('title', trans('content.blog.edit.field.title.title'))
                                            ->with('name', 'title')
                                            ->with('value', old('title', $blog->title))
                                    )
                                    ->push(
                                        component('FormTextarea')
                                            ->with('title', trans('content.blog.edit.field.body.title'))
                                            ->with('name', 'body')
                                            ->with('value', old('body', $blog->body))
                                            ->with('rows', 20)
                                    )
                                    ->push(
                                        component('FormSelectMultiple')
                                            ->with('name', 'destinations')
                                            ->with('options', $destinations)
                                            ->with('value', $blog->destinations->pluck('id'))
                                            ->with('placeholder', trans('content.edit.field.destinations.placeholder'))
                                    )
                                    ->pushWhen(
                                        $blog->url,
                                        component('FormTextfield')
                                            ->with('title', trans('content.blog.edit.field.url.title'))
                                            ->with('name', 'url')
                                            ->with('value', old('url', $blog->url))
                                    )
                                    ->push(component('FormButton')->with('title', trans('content.edit.submit.title')))
                            )
                    )
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function update($id)
    {
        $blog = Content::findOrFail($id);

        $rules = [
            'title' => 'required',
            'body' => 'required'
        ];

        $this->validate(request(), $rules);

        $blog->update([
            'title' => request()->title,
            'body' => request()->body
        ]);

        $blog->destinations()->sync(request()->destinations ?: []);

        return redirect()
            ->route('blog.show', [$blog->slug])
            ->with(
                'info',
                trans('content.update.info', [
                    'title' => $blog->title
                ])
            );
    }
}
