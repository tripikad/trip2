<?php

namespace App\Http\Controllers;

use Request;
use App\Topic;
use App\Content;
use App\Destination;

class V2FlightController extends Controller
{
    public function index()
    {
        $currentDestination = Request::get('destination');
        $currentTopic = Request::get('topic');

        $sliceSize = 10;
        $flights = Content::getLatestPagedItems(
            'flight',
            2 * $sliceSize,
            $currentDestination,
            $currentTopic
        );
        $forums = Content::getLatestItems('forum', 5);
        $destinations = Destination::select('id', 'name')->get();
        $topics = Topic::select('id', 'name')->get();
        $travelmates = Content::getLatestItems('travelmate', 3);

        return view('v2.layouts.2col')

            ->with('header', region('Header', trans('content.flight.index.title')))

            ->with('content', collect()
                ->push(component('AffiliateSearch')->is('wide')->is('purple'))
                ->merge($flights->slice(0, $sliceSize)->map(function ($flight) {
                    return region('FlightRow', $flight);
                })
                )
                ->push(component('Promo')->with('promo', 'body'))
                ->merge($flights->slice($sliceSize)->map(function ($flight) {
                    return region('FlightRow', $flight);
                })
                )
                ->push(region('Paginator', $flights, $currentDestination, $currentTopic))
                ->push(component('AffiliateSearch')->is('wide'))
            )

            ->with('sidebar', collect()
                ->push(component('Block')->with('content', collect()
                    ->push(region(
                        'Filter',
                        $destinations,
                        null,
                        $currentDestination,
                        null,
                        $flights->currentPage(),
                        'v2.flight.index'
                    ))
                ))
                ->push(region('FlightAbout'))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(region('ForumBottom', $forums))
                ->push(region('TravelmateBottom', $travelmates))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }

    public function show($slug)
    {
        $flight = Content::getItemBySlug($slug);
        $flights = Content::getLatestItems('flight', 4);
        $forums = Content::getLatestItems('forum', 5);
        $travelmates = Content::getLatestItems('travelmate', 3);
        $user = auth()->user();

        return view('v2.layouts.2col')

            ->with('header', region('Header', trans('content.flight.index.title')))

            ->with('content', collect()
                ->push(component('Title')->with('title', $flight->vars()->title))
                ->push(component('Meta')
                    ->with('items', collect()
                        ->push(component('MetaLink')
                            ->with('title', $flight->vars()->created_at)
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
                ->push(component('Promo')->with('promo', 'sidebar_large'))
                ->push(component('AffiliateSearch'))
            )

            ->with('bottom', collect()
                ->push(region('ForumBottom', $forums))
                ->push(region('TravelmateBottom', $travelmates))
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
