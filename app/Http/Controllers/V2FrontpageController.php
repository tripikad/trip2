<?php

namespace App\Http\Controllers;

use App\Content;

class V2FrontpageController extends Controller
{
    public function index()
    {

        $topFlights = Content::getLatestItems('flight', 3);
        $bottomFlights = Content::getLatestItems('flight', 3);
        $blogs = Content::getLatestItems('blog', 3);
        $photos = Content::getLatestItems('photo', 6);
        $travelmates = Content::getLatestItems('travelmate', 3);

        return view('v2.layouts.1col')

            ->with('header', region('Header', trans('frontpage.index.search.title')))

            ->with('content', collect()
                ->push(component('Grid3')->with('items', $topFlights->map(function ($topFlight) {
                    $destination = $topFlight->destinations->first();
                    return region('DestinationBar', $destination, $destination->getAncestors())
                        .region('FlightCard', $topFlight);
                })))
                ->push(component('Block')
                    ->is('white')
                    ->is('uppercase')
                    ->with('title', trans('frontpage.index.flight.title'))
                    ->with('content', $bottomFlights->map(function ($bottomFlight) {
                        return region('FlightRow', $bottomFlight);
                    }))
                )
                ->push(component('Block')
                    ->is('white')
                    ->is('uppercase')
                    ->with('title', trans('frontpage.index.blog.title'))
                    ->with('content', $blogs->map(function ($blog) {
                        return component('BlogCard', $blog);
                    }))
                )
                ->push(component('Block')
                    ->is('white')
                    ->is('uppercase')
                    ->with('title', trans('frontpage.index.photo.title'))
                    ->with('content', collect(region('Gallery', $photos)))
                )
                ->push(component('Block')
                    ->is('white')
                    ->is('uppercase')
                    ->with('title', trans('content.travelmate.index.title'))
                    ->with('content', collect()
                        ->push(component('Grid3')
                            ->with('gutter', true)
                            ->with('items', $travelmates->map(function ($post) {
                                    return region('TravelmateCard', $post);
                            }))
                        )
                    )
                )
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }
}
