<?php

namespace App\Http\Controllers;

use App\Content;

class V2NewsController extends Controller
{
    public function index()
    {
        $type = 'news';

        $posts = Content::whereType($type)
            ->whereStatus(1)
            ->take(20)
            ->latest()
            ->get();

        return view('v2.layouts.2col')

            ->with('header', region('Masthead', trans("content.$type.index.title")))

            ->with('content', collect()
                ->push(component('Grid2')
                    ->with('gutter', true)
                    ->with('items', $posts->map(function ($post) {
                        return region('NewsCard', $post);
                    })
                    )
                )
            )

            ->with('sidebar', collect()
                ->push(region('NewsAbout'))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Block')->with('content', collect(['NewsFilter'])))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('footer', region('Footer'));
    }

    public function show($id)
    {
        $post = Content::
            with(
                'images',
                'user',
                'user.images',
                'comments',
                'comments.user',
                'destinations',
                'topics'
            )
            ->whereStatus(1)
            ->find($id);


        return view('v2.layouts.1col')
            ->with('header', region('NewsMasthead', $post))
            ->with('content', collect()
                ->push(component('Body')->is('responsive')->with('body', $post->vars()->body))
                ->merge($post->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
               // ->push(region('CommentCreateForm', $post))
            )
            ->with('footer', region('Footer'));
    }

    public function edit($id)
    {
        $post = Content::whereType('news')
           ->whereStatus(1)
           ->findOrFail($id);

        return view('v2.layouts.fullpage')
            ->with('content', collect()
                ->push(component('Editor')->with('post', $post))
            );
    }
}
