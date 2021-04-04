<?php

namespace App\Http\Controllers;

use App\Services\TravelOfferService;
use App\TravelOffer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TravelOfferController extends Controller
{
    public function index(Request $request, TravelOfferService $service): View
    {
        $showList = false;
        if ($request->get('destination')) {
            $showList = true;
            $items = $service->getListItemsByType('package', $request->get('destination'));
        } else {
            $items = $service->getGridItemsByType('package');
        }

        return view('pages.travel_offer.index', [
            'items' => $items,
            'showList' => $showList,
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

        return view('pages.travel_offer.show', [
            'offer' => $offer
        ]);
    }
}