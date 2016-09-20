<?php

namespace App\Http\Controllers;

use Request;
use App\Content;
use App\Destination;

class V2FlightController extends Controller
{
    public function index()
    {
        $currentDestination = Request::get('destination');

        $firstBatch = 3;
        $secondBatch = 10;
        $thirdBatch = 10;
        $pageSize = $firstBatch + $secondBatch + $thirdBatch;

        $flights = Content::getLatestPagedItems('flight', $pageSize, $currentDestination);
        $forums = Content::getLatestItems('forum', 5);
        $destinations = Destination::select('id', 'name')->get();

        return view('v2.layouts.2col')

            ->with('header', region('Header', trans('content.flight.index.title')))

            ->with('content', collect()
                ->push(component('Grid3')
                    ->with('gutter', true)
                    ->with('items', $flights
                        ->take($firstBatch)
                        ->map(function ($flight) {
                            return region('FlightCard', $flight);
                        })
                    )
                )
                ->merge($flights
                    ->slice($firstBatch)
                    ->take($secondBatch)
                    ->map(function ($flight) {
                        return region('FlightRow', $flight);
                    })
                )
                ->push(component('Promo')->with('promo', 'content'))
                ->merge($flights
                    ->slice($firstBatch + $secondBatch)
                    ->take($thirdBatch)
                    ->map(function ($flight) {
                        return region('FlightRow', $flight);
                    })
                )
                ->push(component('Paginator')
                    ->with('links', $flights->appends([
                        'destination' => $currentDestination,
                    ])
                    ->links())
                )
            )

            ->with('sidebar', collect()
                ->push(region('FlightAbout'))
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
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(region('ForumBottom', $forums))
            )

            ->with('footer', region('Footer'));
    }

    public function show($slug)
    {
        $flight = Content::getItemBySlug($slug);
        $flights = Content::getLatestItems('flight', 3);
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
                ->push(region('FlightBottom', $flights))
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
