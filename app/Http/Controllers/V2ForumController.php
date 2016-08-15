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
        $post = Content::whereType('forum')
            ->whereStatus(1)
            ->findOrFail($id);

        return view('v2.layouts.2col')

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
                ->with('title', 'Foorum')
            )

            ->with('content', collect()
                ->push(region('ForumPost', $post))
                 ->merge($post->comments->map(function ($comment) {
                     return region('Comment', $comment);
                 }))
                ->push(region('CommentCreateForm', $post))
            )

            ->with('footer', region('FooterLight'));
    }
}
