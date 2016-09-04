<?php

namespace App\Http\Controllers;

use App\Destination;
use App\Content;

class V2DestinationController extends Controller
{
    public function show($id)
    {
        $destination = Destination::findOrFail($id);

        $flights = Content::whereType('flight')
            ->whereStatus(1)
            ->latest()
            ->take(3)
            ->get();

        return view('v2.layouts.2col')

            ->with('header', region('DestinationHeader', $destination))

            ->with('content', collect()
                ->push(component('Block')->with('content', collect(['DestinationFlight1'])))
                ->push(component('Block')->with('content', collect(['DestinationPhoto'])))
                ->push(component('Block')->with('content', collect(['DestinationForum'])))
                ->push(component('Promo')->with('promo', 'body'))
                ->push(component('Block')->with('content', collect(['DestinationNews'])))
                ->push(component('Block')->with('content', collect(['DestinationTravelmate'])))
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
