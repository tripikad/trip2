<?php

namespace App\Http\Controllers;

use App\Content;

class V2FrontpageController extends Controller
{
    public function index()
    {
        /*
        @section('head_description', trans('site.description.main'))
        */

        $user = auth()->user();

        $flights = Content::getLatestItems('flight', 9);
        $forums = Content::getLatestItems('forum', 16, 'updated_at');
        $news = Content::getLatestItems('news', 6);
        $blogs = Content::getLatestItems('blog', 3);
        $photos = Content::getLatestItems('photo', 6);
        $travelmates = Content::getLatestItems('travelmate', 5);

        return layout('frontpage')

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
                ->push(component('BlockTitle')
                    ->with('title', trans('frontpage.index.forum.title'))
                    ->with('route', route('v2.forum.index'))
                )
                ->push(component('Body')->with('body', trans('site.description.forum')))
                ->merge(region('ForumLinks'))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
                ->push(component('AffHotelscombined'))
            )

            ->with('bottom1', region('FrontpageNews', $news))

            ->with('bottom2', collect()
                ->push(region('FrontpageBottom', $flights->slice(3), $travelmates))
                ->push(component('BlockTitle')
                    ->with('title', trans('frontpage.index.photo.title'))
                )
                ->push(region('Gallery', $photos))
                ->push(component('BlockTitle')
                    ->with('title', trans('frontpage.index.blog.title'))
                    ->with('route', trans('frontpage.index.blog.title'))
                    ->with('link', component('Link')
                        ->with('title', trans('frontpage.index.all.blog'))
                        ->with('route', route('v2.blog.index'))
                    )
                )
                ->push(component('Grid3')
                    ->with('items', $blogs->map(function ($blog) {
                        return region('BlogCard', $blog);
                    }))
                )
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }
}
