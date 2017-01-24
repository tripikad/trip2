<?php

namespace App\Http\Controllers;

use App\Image;
use App\Content;

class V2StaticController extends Controller
{

    public function show($slug)
    {
        $static = collect([
            'tripist' => 1534,
            'kontakt' => 972,
            'reklaam' => 22125,
            'mis-on-veahind' => 97203,
            'kasutustingimused' => 25151
        ]);

        $post = Content::whereType('static')
            ->whereStatus(1)
            ->findOrFail($static[$slug]);

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
                        ->with('route', route('static.edit', [$post]))
                )
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }
}
