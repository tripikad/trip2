<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;
use App\Topic;

class V2FlightController extends Controller
{
    public function index()
    {
        $type = 'flight';

        $firstBatch = 3;
        $secondBatch = 10;
        $thirdBatch = 10;

        $posts = Content::whereType($type)
            ->whereStatus(1)
            ->take($firstBatch + $secondBatch + $thirdBatch)
            ->latest()
            ->get();

        $forumPosts = Content::whereType('forum')->latest()->skip(10)->take(5)->get();

        $destinations = Destination::select('id', 'name')->get();

        $topics = Topic::select('id', 'name')->get();

        return view('v2.layouts.2col')

            ->with('header', region('Header', trans("content.$type.index.title")))

            ->with('content', collect()
                ->push(component('Grid3')
                    ->with('gutter', true)
                    ->with('items', $flights
                        ->take($firstBatch)
                        ->map(function ($post) {
                            return region('FlightCard', $post);
                        })
                    )
                )
                ->merge($posts
                    ->slice($firstBatch)
                    ->take($secondBatch)
                    ->map(function ($post) {
                        return region('FlightRow', $post);
                    })
                )
                ->push(component('Promo')->with('promo', 'footer'))
                ->merge($posts
                    ->slice($firstBatch + $secondBatch)
                    ->take($thirdBatch)
                    ->map(function ($post) {
                        return region('FlightRow', $post);
                    })
                )
            )

            ->with('sidebar', collect()
                ->push(region('FlightAbout'))
                ->push(component('Block')->with('content', collect()
                    ->push(region('Filter', $destinations, $topics))
                    )
                )
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
                ->push(component('Block')->with('content', collect(['About'])))
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
                            ->with('right_items', $forumPosts->map(function ($forumPost) {
                                return region('ForumRow', $forumPost);
                            }))

                        )
                    )
                )
            )
                //->push(component('Promo')->with('promo', 'footer'))

            ->with('footer', region('Footer'));
    }

    public function show($slug)
    {
        $user = auth()->user();

        $flight = Content::getItemBySlug($slug);

        $flights = Content::getLatestItems('flight', 3);
        $forums = Content::getLatestItems('forum', 5);
        $travelmates = Content::getLatestItems('travelmate', 3);

        return view('v2.layouts.2col')

            ->with('header', region('Header', trans('content.flight.index.title')))

            ->with('content', collect()
                ->push(component('FlightTitle')->with('title', $flight->vars()->title))
                ->push(component('Meta')
                    ->with('items', collect()
                        ->push(component('MetaLink')
                            ->with('title', $flight->vars()->created_at)
                        )
                        ->pushWhen($user && $user->hasRole('admin'), component('MetaLink')
                            ->with('title', trans('content.action.edit.title'))
                            ->with('route', route('v2.flight.edit', [$flight]))
                        )
                    )
                )
                ->push(component('Body')->is('responsive')->with('body', $flight->vars()->body))
                ->merge($flight->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
                ->push(region('Share'))
                ->pushWhen($user && $user->hasRole('regular'), region('CommentCreateForm', $flight))
                ->push(component('Promo')->with('promo', 'body'))
                ->push(component('Block')
                    ->is('white')
                    ->is('uppercase')
                    ->with('title', trans('frontpage.index.flight.title'))
                    ->with('content', $flights->map(function ($flight) {
                        return region('FlightRow', $flight);
                    }))
                )
            )

            ->with('sidebar', collect()
                ->push(region('FlightAbout'))
                ->merge($flight->destinations->map(function ($destination) {
                    return region('DestinationBar', $destination, $destination->getAncestors());
                }))
                ->push(region('ForumSidebar', $forums))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->merge($flights->map(function ($flight) {
                    return region('FlightCard', $flight);
                }))
            )

            ->with('bottom', collect()
                ->push(component('Grid3')->with('items', $flights->map(function ($flight) {
                    return region('FlightCard', $flight);
                })))
                ->push(component('Block')
                    ->is('red')
                    ->is('uppercase')
                    ->is('white')
                    ->with('title', trans('content.travelmate.index.title'))
                    ->with('content', collect()
                        ->push(component('Grid3')->with('gutter', true)->with('items', $travelmates->map(function ($post) {
                            return region('TravelmateCard', $post);
                        })
                        ))
                    )
                )
                ->push(component('Promo')->with('promo', 'footer'))
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
