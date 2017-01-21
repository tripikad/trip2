<?php

namespace App\Http\Controllers;

use App\Image;
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
                        ->with('route', route('v2.static.show', [$post]));
                }))
            );
    }

    public function show($id)
    {
        $post = Content::whereType('static')
            ->whereStatus(1)
            ->findOrFail($id);

        return layout('1col')

            ->with('title', $post->getHeadTitle())
            ->with('head_title', $post->getHeadTitle())
            ->with('head_description', $post->getHeadDescription())
            ->with('head_image', Image::getSocial())

            ->with('header', region('StaticHeader', collect()
                ->push(component('Title')->with('title', $post->vars()->title))
            ))

            ->with('content', collect()
                ->push(component('Body')->is('responsive')->with('body', $post->vars()->body))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }
}
