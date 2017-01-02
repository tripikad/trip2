<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;

class V2DestinationController extends Controller
{
    public function show($id)
    {
        /*
        @section('head_description', trans("site.description.destination", ['name' => $destination->name]))
        */
        
        $destination = Destination::findOrFail($id);

        $flights = Content::getLatestPagedItems('flight', 3, $destination->id);
        $photos = Content::getLatestPagedItems('photo', 6, $destination->id);
        $forums = Content::getLatestPagedItems('forum', 10, $destination->id);
        $news = Content::getLatestPagedItems('news', 3, $destination->id);
        $travelmates = Content::getLatestPagedItems('travelmate', 3, $destination->id);

        return layout('2col')

            ->with('header', region('DestinationHeader', $destination))

            ->with('content', collect()
                ->push(region('Gallery', $photos))
                ->push(component('Block')
                    ->is('uppercase')
                    ->is('white')
                    ->with('title', trans('destination.show.forum.title'))
                    ->with('content', $forums->map(function ($forum) {
                        return region('ForumRow', $forum);
                    })
                    )
                )
                ->push(component('Promo')->with('promo', 'body'))
                ->push(component('Grid3')
                    ->with('gutter', true)
                    ->with('items', $news->map(function ($new) {
                        return region('NewsCard', $new);
                    })
                    )
                )
                ->push(component('Grid3')
                    ->with('gutter', true)
                    ->with('items', $travelmates->map(function ($travelmate) {
                        return region('TravelmateCard', $travelmate);
                    }))
                )
            )

            ->with('sidebar', collect()
                ->merge($flights->map(function ($flight) {
                    return region('FlightCard', $flight);
                }))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }
}
