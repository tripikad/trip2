<?php

namespace App\Http\Controllers;

use App\Offer;

class ExperimentsController extends Controller
{
    public function index()
    {
        $user = null;

        $adventureOffers = Offer::public()
            ->orderBy('start_at')
            ->with(['user:id,name', 'startDestinations', 'endDestinations'])
            ->where('style', '<>', 'package')
            ->take(2)
            ->get();

        $packageOffers = Offer::public()
            ->orderBy('start_at')
            ->with(['user:id,name', 'startDestinations', 'endDestinations'])
            ->where('style', '=', 'package')
            ->take(2)
            ->get();

        //   dd($adventureOffers);

        return layout('Full')
            ->withItems(collect()->merge(region('OfferSection', $adventureOffers, $packageOffers)))
            ->render();
    }
}
