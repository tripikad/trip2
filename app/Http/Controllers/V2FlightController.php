<?php

namespace App\Http\Controllers;

use App\Content;

class V2FlightController extends Controller
{
    public function index()
    {
        $type = 'flight';

        $posts = Content::whereType($type)
            ->whereStatus(1)
            ->take(20)
            ->latest()
            ->get();

        return view('v2.layouts.2col')

            ->with('header', region('Masthead', trans("content.$type.index.title")))

            ->with('content', collect()
                ->merge($posts->map(function ($post) {
                    return region('FlightRow', $post);
                }))
            )

            ->with('sidebar', collect()
                ->push(region('FlightAbout'))
                ->push(component('Block')->with('content', collect(['FlightFilter'])))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
                ->push(component('Block')->with('content', collect(['About'])))
            )

            ->with('bottom', collect()
                ->push(component('Block')->with('content', collect(['ForumBottom'])))
                ->push(component('Block')->with('content', collect(['Promo footer'])))
            )

            ->with('footer', region('Footer'));
    }

    public function show($id)
    {
        $type = 'flight';
        $user = auth()->user();

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
            ->findOrFail($id);

        $posts = Content::whereType($type)
            ->whereStatus(1)
            ->take(3)
            ->latest()
            ->get();

        return view('v2.layouts.2col')

            ->with('header', region('Masthead', trans("content.$type.index.title")))

            ->with('content', collect()
                ->push(component('FlightTitle')->with('title', $post->vars()->title))
                ->push(component('Meta')
                    ->with('items', collect()
                        ->push(component('Link')
                            ->with('title', $post->vars()->created_at)
                        )
                        ->pushWhen($user && $user->hasRole('admin'), component('Link')
                            ->with('title', trans('content.action.edit.title'))
                            ->with('route', route('flight.edit', [$post]))
                        )
                    )
                )
                ->push(component('Body')->is('responsive')->with('body', $post->vars()->body))
                ->merge($post->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
                //->pushWhen(region('CommentCreateForm', $post))
                ->push(component('Block')->with('content', collect(['FlightShare'])))
                ->push(component('Block')->with('content', collect(['Promo content'])))
                ->push(component('Block')->with('content', collect(['FlightRow * 5'])))

            )

            ->with('sidebar', collect()
                ->push(region('FlightAbout'))
                ->push(component('Block')->with('content', collect(['DestinationBar'])))
                ->push(component('Block')->with('content', collect(['5 x ForumRowSmall'])))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->merge($posts->map(function ($post) {
                    return region('FlightCard', $post);
                }))                
            )

            ->with('bottom', collect()
                ->push(component('Block')->with('content', collect(['FlightBottom'])))
                ->push(component('Block')->with('content', collect(['TravelmateBottom'])))
                ->push(component('Block')->with('content', collect(['Promo footer'])))
            )

            ->with('footer', region('Footer'));
    }

    public function edit($id)
    {
        $post = Content::whereType('flight')
           ->whereStatus(1)
           ->findOrFail($id);

        return view('v2.layouts.fullpage')
            ->with('content', collect()
                ->push(component('Editor')->with('post', $post))
            );
    }
}
