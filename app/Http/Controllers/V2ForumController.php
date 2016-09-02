<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;
use App\Topic;

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

        $destinations = Destination::select('id', 'name')->get();

        $topics = Topic::select('id', 'name')->get();

        return view('v2.layouts.2col')
            ->with('header', region('Header', trans("content.$type.index.title")))
            ->with('content', collect()
                ->merge($posts->map(function ($post) {
                    return region('ForumRow', $post);
                }))
            )
            ->with('sidebar', collect()
                ->merge(region('ForumLinks'))
                ->push(region('ForumAbout'))
                ->push(component('Block')->with('content', collect()
                    ->push(region('Filter', $destinations, $topics))
                ))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(component('Grid3')->with('items', $flights->map(function ($flight) {
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

        $posts = Content::whereType($type)
            ->whereStatus(1)
            ->latest()
            ->take(5)
            ->get();

        $travelmates = Content::whereType('travelmate')
            ->whereStatus(1)
            ->latest()
            ->take(3)
            ->get();

        return view('v2.layouts.2col')

            ->with('header', region('Header', trans("content.$type.index.title")))

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
                ->merge($post->destinations->map(function ($destination) {
                    return region('DestinationBar', $destination, $destination->getAncestors());
                }))
                ->push(region('ForumSidebar', $posts))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(component('Block')
                    ->is('red')
                    ->is('uppercase')
                    ->is('white')
                    ->with('title', trans('content.forum.sidebar.title'))
                    ->with('content', collect()
                    ->push(component('ForumBottom')
                        ->with('left_items', region('ForumLinks'))
                        ->with('right_items', $posts->map(function ($post) {
                            return region('ForumRow', $post);
                        }))
                    )))
                ->push(component('Block')->with('content', collect()
                    ->push(component('Grid3')->with('gutter', true)->with('items', $travelmates->map(function ($post) {
                        return region('TravelmateCard', $post);
                    })
                    ))
                ))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('FooterLight'));
    }
}
