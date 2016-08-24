<?php

namespace App\Http\Controllers;

use App\Destination;

class V2DestinationController extends Controller
{
    public function show($id)
    {
        $destination = Destination::findOrFail($id);

        return view('v2.layouts.2col')

            ->with('header', region('DestinationMasthead', $destination))

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
                ->push(component('Block')->with('content', collect(['DestinationFlight2'])))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }
}
