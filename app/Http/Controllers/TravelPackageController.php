<?php

namespace App\Http\Controllers;

use App\Services\TravelOfferService;
use App\Services\TravelPackageService;
use App\TravelOffer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TravelPackageController extends Controller
{
    /**
     * @param Request $request
     * @return bool
     */
    private function showList(Request $request): bool
    {
        $params = ['start_destination', 'end_destination', 'start_date', 'nights'];
        foreach ($params as $param) {
            if ($request->get($param)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Request $request
     * @param TravelPackageService $service
     * @return View
     */
    public function index(Request $request, TravelPackageService $service): View
    {
        $showList = $this->showList($request);
        $items = $showList
            ? $service->getListItemsByType('package', $request)
            : $service->getCheapestOffersByCountry();

        $startDestinations = TravelOfferService::getDistinctStartDestinationsByType('package');
        $endDestinations = TravelOfferService::getAvailableDestinationsByType('package');

        return view('pages.travel_package.index', [
            'backgroundImage' => asset('photos/travel_offer_bg.jpg'),
            'items' => $items,
            'showList' => $showList,
            'startDestinations' => $startDestinations,
            'endDestinations' => $endDestinations,
            'selectedStartDestination' => TravelPackageService::DESTINATION_TALLINN_ID,
            'selectedEndDestination' => $request->get('end_destination'),
            'selectedStartDate' => $request->get('start_date'),
            'selectedNights' => $request->get('nights'),
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
        $offer = TravelOffer::whereSlug($slug)
            ->where('type', 'package')
            ->first();

        if (!$offer) {
            abort(404);
        }

        return view('pages.travel_package.show', [
            'offer' => $offer
        ]);
    }
}