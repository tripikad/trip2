<?php

namespace App\Http\Controllers;

use Request;
use App\Content;
use App\Destination;
use App\Topic;

class V2ForumController extends Controller
{
    public function index()
    {
        $currentDestination = Request::get('destination');
        $currentTopic = Request::get('topic');

        $forums = Content::getLatestPagedItems('forum', false, $currentDestination, $currentTopic);
        $flights = Content::getLatestItems('flight', 3);
        $travelmates = Content::getLatestItems('travelmate', 3);
        $destinations = Destination::select('id', 'name')->get();
        $topics = Topic::select('id', 'name')->get();

        return view('v2.layouts.2col')

            ->with('header', region('HeaderLight', trans('content.forum.index.title')))

            ->with('content', collect()
                ->merge($forums->map(function ($forum) {
                    return region('ForumRow', $forum);
                }))
                ->push(component('Paginator')
                    ->with('links', $forums->appends([
                        'destination' => $currentDestination,
                        'topic' => $currentTopic,
                    ])
                    ->links())
                )
            )

            ->with('sidebar', collect()
                ->merge(region('ForumLinks'))
                ->push(region('ForumAbout'))
                ->push(component('Block')->with('content', collect()
                    ->push(region(
                        'Filter',
                        $destinations,
                        $topics,
                        $currentDestination,
                        $currentTopic,
                        $forums->currentPage(),
                        'v2.forum.index'
                    ))
                ))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(component('Grid3')->with('items', $flights->map(function ($flight) {
                        return region('FlightCard', $flight);
                    })
                ))
                ->push(component('Block')
                    ->is('red')
                    ->is('uppercase')
                    ->is('white')
                    ->with('title', trans('content.travelmate.index.title'))
                    ->with('content', collect()
                        ->push(component('Grid3')
                            ->with('gutter', true)
                            ->with('items', $travelmates->map(function ($travelmate) {
                                return region('TravelmateCard', $travelmate);
                            })
                        ))
                    )
                )
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('FooterLight'));
    }

    public function show($slug)
    {
        $forum = Content::getItemBySlug($slug);
        $forums = Content::getLatestItems('forum', 5);
        $travelmates = Content::getLatestItems('travelmate', 3);
        $user = auth()->user();

        return view('v2.layouts.2col')

            ->with('header', region('HeaderLight', trans('content.forum.index.title')))

            ->with('content', collect()
                ->push(region('ForumPost', $forum))
                ->merge($forum->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
                ->pushWhen($user && $user->hasRole('regular'), region('CommentCreateForm', $forum))
            )

            ->with('sidebar', collect()
                ->merge(region('ForumLinks'))
                ->push(region('ForumAbout'))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->merge($forum->destinations->map(function ($destination) {
                    return region('DestinationBar', $destination, $destination->getAncestors());
                }))
                ->push(region('ForumSidebar', $forums))
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
                        ->with('right_items', $forums->map(function ($forum) {
                            return region('ForumRow', $forum);
                        }))
                    )))
                ->push(component('Block')->with('content', collect()
                    ->push(component('Grid3')
                        ->with('gutter', true)
                        ->with('items', $travelmates->map(function ($travelmate) {
                            return region('TravelmateCard', $travelmate);
                        })
                    ))
                ))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('FooterLight'));
    }
}
