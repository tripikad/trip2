<?php

namespace App\Http\Controllers;

use App\Content;

class V2FrontpageController extends Controller
{
    public function index()
    {
        $flights = Content::getLatestItems('flight', 8);
        $forums = Content::getLatestItems('forum', 24);
        $news = Content::getLatestItems('news', 6);
        $blogs = Content::getLatestItems('blog', 3);
        $photos = Content::getLatestItems('photo', 6);
        $travelmates = Content::getLatestItems('travelmate', 3);
        $user = auth()->user();

        return view('v2.layouts.frontpage')

            ->with('header', region('Header', trans('frontpage.index.search.title')))

            ->with('content', collect()

                ->push(component('Grid3')->with('items', $flights
                    ->take(3)
                    ->map(function ($topFlight, $key) {
                        $destination = $topFlight->destinations->first();

                        return region(
                                'DestinationBar',
                                $destination,
                                $destination->getAncestors(),
                                ['', 'dark', ''][$key]
                            )
                            .region('FlightCard', $topFlight);
                    })
                ))
                ->pushWhen(!$user, region('FrontpageAbout'))
                ->push(region('FrontpageForum', $forums))
                ->push(component('Promo')->with('promo', 'content'))
                ->push(component('Grid3')
                    ->with('gutter', true)
                    ->with('items', $news->map(function ($new) {
                        return region('NewsCard', $new);
                    })
                    )
                )
                ->push(component('GridSplit')
                    ->with('left_content', collect()
                        ->push(component('Block')
                            ->is('white')
                            ->is('uppercase')
                            ->with('title', trans('frontpage.index.flight.title'))
                            ->with('content', $flights->slice(3)->map(function ($bottomFlight) {
                                return region('FlightRow', $bottomFlight);
                            }))
                        )
                    )
                    ->with('right_content', collect()
                        ->push(component('Block')
                            ->is('white')
                            ->is('uppercase')
                            ->with('title', trans('frontpage.index.blog.title'))
                            ->with('content', $blogs->map(function ($blog) {
                                return region('BlogCard', $blog);
                            }))
                        )
                    )
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
