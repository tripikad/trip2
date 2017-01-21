<?php

namespace App\Http\Controllers;

use App\Content;

class V2BlogController extends Controller
{
    public function index()
    {
        $blogs = Content::getLatestPagedItems('blog', 10);
        $loggedUser = request()->user();

        return layout('2col')

            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->is('large')
                    ->with('title', trans('content.blog.index.title'))
                    ->with('route', route('v2.blog.index'))
                )
            ))

            ->with('content', collect()
                ->merge($blogs->flatMap(function ($blog) {
                    return collect()
                        ->push(region('BlogRow', $blog))
                        ->push(component('Body')
                            ->is('responsive')
                            ->with('body', $blog->vars()->body)
                        );
                }))
                ->push(region('Paginator', $blogs))
            )

            ->with('sidebar', collect()
                ->pushWhen(
                    $loggedUser && $loggedUser->hasRole('regular'),
                    component('Button')
                        ->with('title', trans("content.blog.create.title"))
                        ->with('route', route('content.create', ['blog']))
                )
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function show($slug)
    {
        $blog = Content::getItemBySlug($slug);
        $user = auth()->user();

        return view('v2.layouts.2col')

            ->with('header', region('Header', collect()
                ->push(component('Link')
                    ->is('white')
                    ->is('large')
                    ->with('title', trans('content.blog.show.action.all'))
                    ->with('route', route('v2.blog.index'))
                )
                ->push(component('Title')
                    ->is('white')
                    ->is('large')
                    ->with('title', trans('content.blog.index.title'))
                    ->with('route', route('v2.blog.index'))
                )
            ))

            ->with('content', collect()
                ->push(region('BlogRow', $blog))
                ->push(component('Body')->is('responsive')->with('body', $blog->vars()->body))
                ->merge($blog->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
                ->pushWhen(
                    $user && $user->hasRole('regular'),
                    region('CommentCreateForm', $blog)
                )
            )

            ->with('sidebar', collect()
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }
}
