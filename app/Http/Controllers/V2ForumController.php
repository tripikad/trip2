<?php

namespace App\Http\Controllers;

use App\Content;

class V2ForumController extends Controller
{
    public function index()
    {
        $posts = Content::whereType('forum')
            ->whereStatus(1)
            ->latest()
            ->take(10)
            ->get();

        return view('v2.layouts.1col')
            ->with('content', collect()
                ->merge($posts->map(function ($post) {
                    return component('Link')
                        ->with('title', $post->vars()->title)
                        ->with('route', route('forum.show', [$post]));
                }))
            );
    }

    public function show($id)
    {
        $type = 'forum';

        $post = Content::whereType($type)
            ->whereStatus(1)
            ->findOrFail($id);

        return view('v2.layouts.2col')

            ->with('header', region('Masthead', trans("content.$type.index.title")))

            ->with('content', collect()
                ->push(region('ForumPost', $post))
                 ->merge($post->comments->map(function ($comment) {
                     return region('Comment', $comment);
                 }))
                //->push(region('CommentCreateForm', $post))
            )

            ->with('sidebar', collect()
                ->push(component('Block')
                    ->with('content', collect()
                        ->push(component('Body')
                            ->with('body', trans("site.description.$type"))
                        )
                        ->push(component('Button')
                            ->with('title', trans("content.$type.create.title"))
                            ->with('route', route('content.create', [$type]))
                        )
                    )
                )
            )

            ->with('footer', region('FooterLight'));
    }
}
