<?php

namespace App\Http\Controllers;

use App\Content;

class V2FrontpageController extends Controller
{
    public function index()
    {
        $topFlights = Content::getLatestItems('flight', 3);
        $photos = Content::getLatestItems('photo', 6);

        return view('v2.layouts.1col')

            ->with('header', region('Header', trans('frontpage.index.search.title')))

            ->with('content', collect()
                ->push(component('Grid3')->with('items', $topFlights
                    ->map(function ($topFlight) {
                        return region('FlightCard', $topFlight);
                    })
                ))
                ->push(component('Block')->is('white')->with('content', collect(region('Gallery', $photos))))
                ->push(component('Block')->with('content', collect(['FrontpageFlightCards'])))
            )

            ->with('footer', region('Footer'));
    }
}
