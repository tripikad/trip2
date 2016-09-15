<?php

namespace App\Http\Controllers;

use App\Destination;
use App\Content;

class V2DestinationController extends Controller
{
    public function show($id)
    {
        $destination = Destination::findOrFail($id);

        // TODO: Replace with $destination->content()->whereType(...+ fallbacks

        $flights = Content::getLatestItems('flight', 3);
        $photos = Content::getLatestItems('photo', 6);
        $forums = Content::getLatestItems('forum', 5);
        $news = Content::getLatestItems('news', 3);
        $travelmates = Content::getLatestItems('travelmate', 3);

        return view('v2.layouts.2col')

            ->with('header', region('DestinationHeader', $destination))

            ->with('content', collect()
                ->push(component('Grid3')
                    ->with('items', $flights->map(function ($flight) {
                            return region('FlightCard', $flight);
                        })
                    )
                )
                ->push(region('Gallery', $photos))
                ->push(region('ForumSidebar', $forums))
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
                    })
                ))
            )

            ->with('sidebar', collect()
                ->push(component('Block')->with('content', collect(['DestinationPopular'])))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(component('Grid3')->with('items', $flights->map(function ($flight) {
                    return region('FlightCard', $flight);
                })
                ))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }
}
