<?php

namespace App\Http\Controllers;

use App\Content;

class V2StaticController extends Controller
{
    public function index()
    {
        $posts = Content::whereType('static')
            ->whereStatus(1)
            ->latest()
            ->get();

        return view('v2.layouts.1col')
            ->with('content', collect()
                ->merge($posts->map(function ($post) {
                    return component('MetaLink')
                        ->with('title', $post->vars()->title)
                        ->with('route', route('static.show', [$post]));
                }))
            );
    }

    public function show($id)
    {
        $post = Content::whereType('static')
            ->whereStatus(1)
            ->findOrFail($id);

        return view('v2.layouts.1col')

            ->with('header', region('Masthead', $post->vars()->title))

            ->with('content', collect()
                ->push(component('Body')->with('body', $post->vars()->body))
            )

            ->with('footer', region('FooterLight'));
    }
}
