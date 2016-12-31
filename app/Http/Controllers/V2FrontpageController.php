<?php

namespace App\Http\Controllers;

use App\Content;

class V2FrontpageController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $flights = Content::getLatestItems('flight', 9);
        $forums = Content::getLatestItems('forum', 16, 'updated_at');
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

            ->with('header', region('Header',
                component('FrontpageSearch')
                    ->with('title', trans('frontpage.index.search.title'))
            ))

            ->with('top', collect()
                ->push(region('FrontpageFlight', $flights->take(3)))
                ->pushWhen(! $user, region('FrontpageAbout'))
            )

            ->with('content', collect()
                ->merge($forums->take($forums->count() / 2)->map(function ($forum) {
                    return region('ForumRow', $forum);
                }))
                ->push(component('Promo')->with('promo', 'body'))
                ->merge($forums->slice($forums->count() / 2)->map(function ($forum) {
                    return region('ForumRow', $forum);
                }))
            )

            ->with('sidebar', collect()
                ->push(component('Block')
                    ->is('white')
                    ->is('uppercase')
                    ->with('title', trans('frontpage.index.forum.title'))
                    ->with('content', region('ForumLinks'))
                )
                ->push(region('ForumAbout', 'white'))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
                ->push(component('AffiliateSearch'))
            )

            ->with('bottom1', collect()
                ->push(region('FrontpageNews', $news))
            )

            ->with('bottom2', collect()
                ->push(region('FrontpageFlightBlog', $flights->slice(3), $blogs))
                ->push(component('Block')
                    ->is('white')
                    ->is('uppercase')
                    ->with('title', trans('frontpage.index.photo.title'))
                    ->with('content', collect(region('Gallery', $photos)))
                )
                ->push(component('Block')
                    ->is('white')
                    ->is('uppercase')
                    ->with('title', trans('frontpage.index.travelmate.title'))
                    ->with('content', [])
                )
                ->push(component('Grid3')
                    ->with('items', $travelmates->map(function ($travelmate) {
                        return region('TravelmateCard', $travelmate);
                    }))
                )
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }
}
