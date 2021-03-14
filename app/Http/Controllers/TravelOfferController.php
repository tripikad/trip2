<?php

namespace App\Http\Controllers;

use App\TravelOffer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TravelOfferController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.travel_offer.index', [
            'packages' => [],
            'categories' => [],
        ]);
    }

    /**
     * @param string $slug
     * @param Request $request
     * @return View
     */
    public function show(string $slug, Request $request): View
    {
        $offer = TravelOffer::whereSlug($slug)->first();
        if (!$offer) {
            abort(404);
        }

        return view('pages.travel_offer.show', [
            'offer' => $offer
        ]);
    }
}