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

        $loggedUser = auth()->user();

        $flights = Content::getLatestItems('flight', 9);
        $forums = Content::getLatestItems('forum', 16, 'updated_at');
        $news = Content::getLatestItems('news', 6);
        $blogs = Content::getLatestItems('blog', 3);
        $photos = Content::getLatestItems('photo', 9);
        $travelmates = Content::getLatestItems('travelmate', 5);

        return layout('frontpage')

            ->with('promobar', component('PromoBar')
                ->with('title', 'Osale Trip.ee kampaanias ja võida 2 lennupiletit Maltale')
                ->with('route_title', 'Vaata lähemalt siit')
                ->with('route', 'tasuta-lennupiletid-maltale')
                ->render()
            )

            ->with('header', region('FrontpageHeader'))

            ->with('top', collect()
                ->push(region('FrontpageFlight', $flights->take(3)))
                ->pushWhen(! $loggedUser, region('FrontpageAbout'))
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

            ->with('bottom1', collect()
                ->merge(region('FrontpageNews', $news))
                ->push(component('BlockTitle')
                    ->with('title', trans('frontpage.index.photo.title'))
                )
            )

            ->with('bottom2', region(
                'PhotoRow',
                $photos,
                collect()
                    ->push(
                        component('Button')
                            ->is('transparent')
                            ->with('title', trans('content.photo.more'))
                            ->with('route', route('v2.photo.index'))
                    )
                    ->pushWhen(
                        $loggedUser && $loggedUser->hasRole('regular'),
                        component('Button')
                            ->is('transparent')
                            ->with('title', trans('content.photo.create.title'))
                            ->with('route', route('content.create', ['photo']))
                    )
            ))

            ->with('bottom3', collect()
                ->push(region('FrontpageBottom', $flights->slice(3), $travelmates))
                ->push(component('Block')
                    ->with('title', trans('frontpage.index.blog.title'))
                    ->with('route', trans('frontpage.index.blog.title'))
                    ->with('content', collect()
                        ->push(component('Grid3')
                            ->with('items', $blogs->map(function ($blog) {
                                return region('BlogCard', $blog);
                            }))
                        )
                    )
                )
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }
}
