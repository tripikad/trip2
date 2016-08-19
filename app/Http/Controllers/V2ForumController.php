<?php

namespace App\Http\Controllers;

use App\Content;

class V2ForumController extends Controller
{
    public function index()
    {
        $type = 'forum';

        $posts = Content::whereType($type)
            ->whereStatus(1)
            ->latest()
            ->take(10)
            ->get();

        $flights = Content::whereType('flight')
            ->whereStatus(1)
            ->latest()
            ->take(3)
            ->get();

        return view('v2.layouts.2col')
            ->with('header', region('Masthead', trans("content.$type.index.title")))
            ->with('content', collect()
                ->merge($posts->map(function ($post) {
                    return region('ForumRow', $post);
                }))
            )
            ->with('sidebar', collect()
                ->merge(region('ForumLinks'))
                ->push(region('ForumAbout'))
                ->push(component('Block')->with('content', collect(['ForumFilter'])))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(component('FlightBottom')->with('items', $flights->map(function($flight) {
                        return region('FlightCard', $flight);
                    })
                ))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('FooterLight'));
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
                ->merge(region('ForumLinks'))
                ->push(region('ForumAbout'))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Block')->with('content', collect(['DestinationBar'])))
                ->push(component('Block')->with('content', collect(['5 x ForumRowSmall'])))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(component('Block')->with('content', collect(['ForumBottom'])))
                ->push(component('Block')->with('content', collect(['TravelmateBottom'])))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('FooterLight'));
    }
}
