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
        /*
        @section('title', trans("content.$type.index.title"))
        @section('head_description', trans('site.description.flight'))
        */

        $currentDestination = Request::get('destination');
        $currentTopic = Request::get('topic');

        $sliceSize = 10;
        $flights = Content::getLatestPagedItems(
            'flight',
            2 * $sliceSize,
            $currentDestination,
            $currentTopic
        );
        $forums = Content::getLatestPagedItems('forum', 4, null, null, 'updated_at');
        $destinations = Destination::select('id', 'name')->get();
        $topics = Topic::select('id', 'name')->get();

        $travelmates = Content::getLatestItems('travelmate', 3);
        $news = Content::getLatestItems('news', 1);

        return layout('2col')

            ->with('header', region('Header', trans('content.flight.index.title')))

            ->with('content', collect()
                ->push(component('AffMomondo'))
                ->merge($flights->slice(0, $sliceSize)->map(function ($flight) {
                    return region('FlightRow', $flight);
                })
                )
                ->push(component('Promo')->with('promo', 'body'))
                ->merge($flights->slice($sliceSize)->map(function ($flight) {
                    return region('FlightRow', $flight);
                })
                )
                ->push(
                    region('Paginator', $flights, $currentDestination, $currentTopic)
                )
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
                ->push(component('AffHotelscombined'))

            )

            ->with('bottom', collect()
                ->push(region('FlightBottom', $forums, $travelmates, $news))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function show($slug)
    {
        /*
        @section('title', trans("content.$type.index.title"))
        @section('head_title',  $content->getHeadTitle())
        @section('head_description', $content->getHeadDescription())
        @section('head_image', $content->getHeadImage())
        */

        $flight = Content::getItemBySlug($slug);
        $flights = Content::getLatestItems('flight', 4);
        $forums = Content::getLatestPagedItems('forum', 4, null, null, 'updated_at');
        $travelmates = Content::getLatestItems('travelmate', 3);
        $news = Content::getLatestItems('news', 1);

        $user = auth()->user();

        return layout('2col')

            ->with('header', region('Header', trans('content.flight.index.title')))

            ->with('content', collect()
                ->push(component('Title')->with('title', $flight->vars()->title))
                ->push(component('Meta')
                    ->with('items', collect()
                        ->push(component('MetaLink')
                            ->with('title', $flight->vars()->created_at)
                        )
                        ->merge($flight->destinations->map(function ($destination) {
                            return component('Tag')
                                ->is('orange')
                                ->with('title', $destination->name)
                                ->with('route', route('v2.destination.show', [$destination]));
                        }))
                    )
                )
                ->push(component('Body')->is('responsive')->with('body', $flight->vars()->body))
                ->merge($flight->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
                ->push(component('AffBookingInspiration'))
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
                ->push(component('AffRentalcars'))
                ->push(component('AffBookingSearch'))
            )

            ->with('bottom', collect()
                ->push(region('FlightBottom', $forums, $travelmates, $news))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }
}
