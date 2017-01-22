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

        $loggedUser = request()->user();

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
                ->pushWhen($loggedUser && $loggedUser->hasRoleOrOwner('admin', $post->user->id),
                    component('MetaLink')
                        ->with('title', trans('content.action.edit.title'))
                        ->with('route', route('content.edit', [$post->type, $post]))
                )
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }
}
