<?php

namespace App\Http\Controllers;

use App\Content;

class V2TravelmateController extends Controller
{
    public function index()
    {
        $type = 'travelmate';

        $posts = Content::whereType($type)
            ->whereStatus(1)
            ->skip(40)
            ->take(20)
            ->latest()
            ->get();

        return view('v2.layouts.2col')

            ->with('header', region('Masthead', trans("content.$type.index.title")))

            ->with('content', collect()
                ->push(component('NewsGrid')
                    ->with('items', $posts->map(function ($post) {
                        return region('TravelmateCard', $post);
                    })
                    )
                )
            )

            ->with('sidebar', collect()
                ->push(component('Block')->with('content', collect(['TravelmateAbout'])))
                ->push(component('Block')->with('content', collect(['TravelmateFilter'])))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Block')->with('content', collect(['About'])))
            )

            ->with('bottom', collect()
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }

    public function show($id)
    {
        $type = 'travelmate';
        $user = auth()->user();

        $post = Content::
            with(
                'user',
                'user.images'
            )
            ->whereStatus(1)
            ->findOrFail($id);

        $flights = Content::whereType('flight')
            ->whereStatus(1)
            ->latest()
            ->take(3)
            ->get();

        return view('v2.layouts.2col')

            ->with('header', region('Masthead', trans("content.$type.index.title")))

            ->with('content', collect()
                ->push(component('Title')->with('title', $post->vars()->title))
                ->push(component('Meta')
                    ->with('items', collect()
                        ->push(component('MetaLink')
                            ->with('title', $post->vars()->created_at)
                        )
                        ->pushWhen($user && $user->hasRole('admin'), component('MetaLink')
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
            )

            ->with('sidebar', collect()
                ->push(component('Block')->with('content', collect(['ProfileCard'])))
                ->push(component('Block')->with('content', collect(['DestinationBar'])))
                ->push(component('Block')->with('content', collect(['5 x ForumRowSmall'])))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
            )

            ->with('bottom', collect()
                ->push(component('FlightBottom')->with('items', $flights->map(function ($flight) {
                    return region('FlightCard', $flight);
                })
                ))
                ->push(component('Block')->with('content', collect(['TravelmateBottom'])))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }
}
