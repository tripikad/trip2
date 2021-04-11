<?php

namespace App\Http\Controllers;

use App\Services\TravelOfferService;
use App\Services\TravelPackageService;
use App\TravelOffer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TravelPackageController extends Controller
{
    public function index(Request $request, TravelPackageService $service): View
    {
        $showList = false;
        if ($request->get('destination')) {
            $showList = true;
            $items = $service->getListItemsByType('package', $request->get('destination'));
        } else {
            $items = $service->getCheapestOffersByCountry();
        }

        $startDestinations = TravelOfferService::getAvailableDestinationsByType('package', false);
        $endDestinations = TravelOfferService::getAvailableDestinationsByType('package');

        return view('pages.travel_package.index', [
            'backgroundImage' => asset('photos/travel_offer_bg.jpg'),
            'items' => $items,
            'showList' => $showList,
            'startDestinations' => $startDestinations,
            'endDestinations' => $endDestinations,
            'filters' => [
                [
                    'id' => 'start',
                    'name' => 'Sorteeri kuupäeva järgi'
                ],
                [
                    'id' => 'price',
                    'name' => 'Sorteeri hinna järgi'
                ],
            ]
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

        return view('pages.travel_package.show', [
            'offer' => $offer
        ]);
    }
}