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
                    return component('Link')
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

            ->with('header', component('Masthead')
                ->with('header', component('Header')
                    ->with('search', component('HeaderSearch')->is('gray'))
                    ->with('logo', component('Icon')
                        ->with('icon', 'tripee_logo_plain_dark')
                        ->with('width', 80)
                        ->with('height', 30)
                    )
                    ->with('navbar', region('Navbar'))
                    ->with('navbar_mobile', region('NavbarMobile'))
                )
                ->with('title', $post->vars()->title)
            )

            ->with('content', collect()
                ->push(component('Body')->with('body', $post->vars()->body))
            )

            ->with('footer', region('FooterLight'));
    }
}
