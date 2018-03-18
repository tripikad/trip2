<?php

namespace App\Http\Controllers;

use App\Content;

class CampaignController extends Controller
{
    public function index()
    {
        $flights = Content::getLatestItems('flight', 9, 'id');

        return layout('constanta_campaign')

            ->setLayoutName('layouts.campaign.Constanta.campaign')

            ->with('color', 'gray')

            ->with('header', region('Header'))

            ->with('content', collect()
                ->push(component('Block')
                    ->with('title', trans('frontpage.index.flight.title'))
                    ->with('route', route('flight.index'))
                    ->with('content', $flights->map(function ($flight) {
                        return region('FlightRow', $flight);
                    }))
                )
            )

            ->with('HotelsCombined', component('AffHotelscombined'))

            ->with('FbBackpackWidget', component('FbBackpackWidget'))

            ->with('footer', region('Footer'))

            ->render();
    }
}
