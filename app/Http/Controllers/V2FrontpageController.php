<?php

namespace App\Http\Controllers;

use App\Content;

class V2FrontpageController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $flights = Content::getLatestItems('flight', 8);
        $forums = Content::getLatestItems('forum', $user ? 10 : 8);
        $news = Content::getLatestItems('news', 6);
        $blogs = Content::getLatestItems('blog', 3);
        $photos = Content::getLatestItems('photo', 6);
        $travelmates = Content::getLatestItems('travelmate', 3);

        return view('v2.layouts.frontpage')

            ->with('promobar', component('PromoBar')
                ->with('title', 'Osale Trip.ee kampaanias ja võida 2 lennupiletit Maltale')
                ->with('route_title', 'Vaata lähemalt siit')
                ->with('route', 'tasuta-lennupiletid-maltale')
                ->render()
            )

            ->with('header', region('FrontpageHeader',
                component('FrontpageSearch')
                    ->with('title', trans('frontpage.index.search.title'))
            ))

            ->with('content', collect()

                ->push(region('FrontpageFlight', $flights->take(3)))
                ->pushWhen(! $user, region('FrontpageAbout'))
                ->push(region('FrontpageForum', $forums))
                ->push(region('FrontpageNews', $news))
            )

            ->with('bottom', collect()
                ->push(region('FrontpageFlightBlog', $flights->slice(3), $blogs))
                ->push(component('Block')
                    ->is('white')
                    ->is('uppercase')
                    ->with('title', trans('frontpage.index.photo.title'))
                    ->with('content', collect(region('Gallery', $photos)))
                )
                ->push(region('TravelmateBottom', $travelmates))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }
}
