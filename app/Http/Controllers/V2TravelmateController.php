<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;
use App\Topic;

class V2TravelmateController extends Controller
{
    public function index()
    {
        $type = 'travelmate';

        $destinations = Destination::select('id', 'name')->get();

        $topics = Topic::select('id', 'name')->get();

        $posts = Content::whereType($type)
            ->whereStatus(1)
            ->skip(40)
            ->take(20)
            ->latest()
            ->get();

        return view('v2.layouts.2col')

            ->with('header', region('Header', trans("content.$type.index.title")))

            ->with('content', collect()
                ->push(component('Grid2')
                        ->with('gutter', true)
                        ->with('items', $posts->map(function ($post) {
                            return region('TravelmateCard', $post);
                        })
                    )
                )
            )

            ->with('sidebar', collect()
                    ->push(region('TravelmateAbout'))
                ->push(component('Block')->with('content', collect()
                    ->push(region('Filter', $destinations, $topics))
                    )
                )
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

        $forums = Content::whereType('forum')
            ->whereStatus(1)
            ->take(5)
            ->latest()
            ->get();

        $flights = Content::whereType('flight')
            ->whereStatus(1)
            ->latest()
            ->take(3)
            ->get();

        return view('v2.layouts.2col')

            ->with('header', region('Header', trans("content.$type.index.title")))

            ->with('content', collect()
                ->push(component('FlightTitle')->with('title', $post->vars()->title))
                ->push(component('Meta')
                    ->with('items', collect()
                        ->push(component('MetaLink')
                            ->with('title', $post->vars()->created_at)
                        )
                        ->pushWhen($user && $user->hasRole('admin'), component('MetaLink')
                            ->with('title', trans('content.action.edit.title'))
                            ->with('route', route('flight.edit', [$post]))
                        )
                        ->merge($post->destinations->map(function ($tag) {
                            return component('Tag')->is('orange')->with('title', $tag->name);
                        }))
                        ->merge($post->topics->map(function ($tag) {
                            return component('Tag')->with('title', $tag->name);
                        }))
                    )
                )
                ->push(component('Body')->is('responsive')->with('body', $post->vars()->body))
                ->push(region('Share'))

                ->merge($post->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
                //->pushWhen(region('CommentCreateForm', $post))

            )

            ->with('sidebar', collect()
                ->push(region('UserCard', $post))
                ->merge($post->destinations->map(function ($destination) {
                    return region('DestinationBar', $destination, $destination->getAncestors());
                }))
                ->merge($flights->map(function ($flight) {
                    return region('FlightCard', $flight);
                }))
                ->push(region('ForumSidebar', $forums))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
            )

            ->with('bottom', collect()
                ->push(component('Grid3')
                    ->with('gutter', true)
                    ->with('items', $posts->map(function ($post) {
                        return region('TravelmateCard', $post);
                    })
                ))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }
}
