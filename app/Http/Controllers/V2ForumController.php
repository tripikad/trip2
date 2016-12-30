<?php

namespace App\Http\Controllers;

use Cache;
use Request;
use App\Topic;
use App\Content;
use App\Destination;

class V2ForumController extends Controller
{
    public function index()
    {
        $currentDestination = Request::get('destination');
        $currentTopic = Request::get('topic');

        $forums = Content::getLatestPagedItems('forum', false, $currentDestination, $currentTopic);
        $flights = Content::getLatestItems('flight', 4);
        $destinations = Destination::select('id', 'name')->get();
        $topics = Topic::select('id', 'name')->get();

        return view('v2.layouts.2col')

            ->with('header', region('HeaderLight', trans('content.forum.index.title')))

            ->with('content', collect()
                ->merge($forums->map(function ($forum) {
                    return region('ForumRow', $forum);
                }))
                ->push(region('Paginator', $forums, $currentDestination, $currentTopic))
            )

            ->with('sidebar', collect()
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
                ->merge(region('ForumLinks'))
                ->push(region('ForumAbout'))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(region('FlightBottom', $flights))
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

        // Clear the unread cache
        
        if ($user) {
            
            $key = 'new_'.$forum->id.'_'.$user->id;
            Cache::forget($key);
        
        }
        
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
                ->push(region('ForumBottom', $forums))
                ->push(region('TravelmateBottom', $travelmates))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('FooterLight'));
    }
}
