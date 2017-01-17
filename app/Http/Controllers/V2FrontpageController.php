<?php

namespace App\Http\Controllers;

use App\Content;
use App\Image;

class V2FrontpageController extends Controller
{
    public function index()
    {
 
        $loggedUser = auth()->user();

        $flights = Content::getLatestItems('flight', 9);
        $forums = Content::getLatestItems('forum', 16, 'updated_at');
        $news = Content::getLatestItems('news', 6);
        $blogs = Content::getLatestItems('blog', 3);
        $photos = Content::getLatestItems('photo', 9);
        $travelmates = Content::getLatestItems('travelmate', 5);

        return layout('frontpage')

            ->with('title', trans('site.about'))
            ->with('head_title', trans('site.about'))
            ->with('head_description', trans('site.description.main'))
            ->with('head_image', Image::getSocial())

            ->with('promobar', component('PromoBar')
                ->with('title', 'Osale Trip.ee kampaanias ja võida 2 lennupiletit Maltale')
                ->with('route_title', 'Vaata lähemalt siit')
                ->with('route', 'tasuta-lennupiletid-maltale')
                ->render()
            )

            ->with('header', region('FrontpageHeader'))

            ->with('top', collect()
                ->push(region('FrontpageFlight', $flights->take(3)))
                ->push(component('BlockHorizontal')
                    ->is('right')
                    ->with('content', collect()->push(component('Link')
                        ->is('blue')
                        ->with('title', trans('frontpage.index.all.offers'))
                        ->with('route', route('v2.flight.index'))
                    ))
                )
                ->pushWhen(! $loggedUser, '&nbsp;')
                ->pushWhen(! $loggedUser, region('FrontpageAbout'))
            )

            ->with('content', collect()
                ->push(component('BlockTitle')
                    ->with('title', trans('frontpage.index.forum.title'))
                    ->with('route', route('v2.forum.index'))
                )
                ->merge($forums->take($forums->count() / 2)->map(function ($forum) {
                    return region('ForumRow', $forum);
                }))
                ->push(component('Promo')->with('promo', 'body'))
                ->merge($forums->slice($forums->count() / 2)->map(function ($forum) {
                    return region('ForumRow', $forum);
                }))
            )

            ->with('sidebar', collect()
                ->merge(collect(['forum', 'buysell', 'expat'])
                    ->flatMap(function($type) {
                        return collect()
                            ->push(component('Link')
                                ->is('large')
                                ->with('title', trans("content.$type.index.title"))
                                ->with('route', route("v2.$type.index"))
                            )
                            ->push(component('Body')
                                ->is('gray')
                                ->with('body', trans("site.description.$type"))
                            );
                    })
                )
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
                ->push(component('AffHotelscombined'))
            )

            ->with('bottom1', collect()
                ->merge(region('FrontpageNews', $news))
                ->push(component('BlockTitle')
                    ->with('title', trans('frontpage.index.photo.title'))
                    ->with('route', route('v2.photo.index'))
                )
            )

            ->with('bottom2', region(
                'PhotoRow',
                $photos,
                collect()
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
                    ->with('route', route('v2.blog.index'))
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
