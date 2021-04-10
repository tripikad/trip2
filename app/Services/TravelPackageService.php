<?php

namespace App\Services;

use App\Company;
use App\Destination;
use App\TravelOffer;
use App\TravelOfferHotel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;

class TravelPackageService extends TravelOfferService
{
    /**
     * @param Company $company
     * @param Request $request
     * @param TravelOffer|null $travelOffer
     * @return TravelOffer|MessageBag
     */
    private static function saveTravelPackage(Company $company, Request $request, TravelOffer $travelOffer = null)
    {
        $add = !$travelOffer;
        $destinations = Destination::get()->pluck('name', 'id')->toArray();
        $rules = [
            'start_destination' => [
                'required',
                Rule::in(array_keys($destinations)),
            ],
            'end_destination' => [
                'required',
                Rule::in(array_keys($destinations)),
            ],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ];

        $validator = Validator::make($request->post(), $rules);
        $validator->after(function ($validator) use ($request) {
            $hotelErrors = (new self)->validateHotels($request);
            if ($hotelErrors) {
                $validator->errors()->add(
                    'hotel', 'Hotelli väljad on puudulikud'
                );
                $validator->errors()->merge(['hotels' => json_encode($hotelErrors)]);
            }
        });

        if ($validator->fails()) {
            return $validator->errors();
        }

        $hotels = $request->post('hotel');
        $price = $hotels[0]['price'];
        foreach ($hotels as $hotel) {
            if ($hotel['price'] < $price) {
                $price = $hotel['price'];
            }
        }

        $endDestinationName = $destinations[$request->post('end_destination')];

        $travelOffer = $travelOffer ?? new TravelOffer();
        if ($add) {
            $travelOffer->company_id = $company->id;
        }

        $travelOffer->slug = null;
        $travelOffer->name = $endDestinationName . ' ' . $request->post('start_date');
        $travelOffer->start_destination_id = $request->post('start_destination');
        $travelOffer->end_destination_id = $request->post('end_destination');
        $travelOffer->start_date = Carbon::parse($request->post('start_date'));
        $travelOffer->end_date =  Carbon::parse($request->post('end_date'));
        $travelOffer->price = $price;
        $travelOffer->description = $request->post('description');
        $travelOffer->accommodation = $request->post('accommodation');
        $travelOffer->included = $request->post('included');
        $travelOffer->excluded = $request->post('excluded');
        $travelOffer->extra_fee = $request->post('extra_fee');
        $travelOffer->extra_info = $request->post('extra_info');
        $travelOffer->save();

        if (!$add) {
            $travelOffer->hotels()->delete();
        }

        foreach ($hotels as $hotel) {
            $travelOfferHotel = new TravelOfferHotel();
            $travelOfferHotel->travel_offer_id = $travelOffer->id;
            $travelOfferHotel->name = $hotel['name'];
            $travelOfferHotel->price = $hotel['price'];
            $travelOfferHotel->star = isset($hotel['star']) ? $hotel['star'] : null;
            $travelOfferHotel->accommodation = isset($hotel['accommodation']) ? $hotel['accommodation'] : null;
            $travelOfferHotel->link = isset($hotel['link']) ? $hotel['link'] : null;
            $travelOfferHotel->save();
        }

        return $travelOffer;
    }

    /**
     * @param Company $company
     * @param Request $request
     * @return TravelOffer|MessageBag
     */
    public static function storeTravelPackage(Company $company, Request $request)
    {
        return self::saveTravelPackage($company, $request);
    }

    /**
     * @param Company $company
     * @param Request $request
     * @param TravelOffer $travelOffer
     * @return TravelOffer|MessageBag
     */
    public static function updateTravelPackage(Company $company, Request $request, TravelOffer $travelOffer)
    {
        return self::saveTravelPackage($company, $request, $travelOffer);
    }

    /**
     * @return array
     */
    public function getCheapestOffersByCountry(): array
    {
        $items = TravelOffer::where('type', 'package')
            ->select('travel_offers.*', 'd2.id as parentDestinationId', 'd2.name as parentDestinationName')
            ->join('destinations as d1', 'travel_offers.end_destination_id', '=', 'd1.id')
            ->join('destinations as d2', 'd1.parent_id', '=', 'd2.id')
            //->where('active', true)
            ->get();

        $res = [];
        foreach ($items as $item) {
            $parentDestinationId = $item->parentDestinationId;
            if (!isset($res[$parentDestinationId])) {
                $res[$parentDestinationId] = $item;
            } else {
                if ($item->price < $res[$parentDestinationId]['price']) {
                    $res[$parentDestinationId] = $item;
                }
            }
        }

        return $res;
    }

    public function getListItemsByType(string $type, int $destinationId)
    {
        $destinationIds = Destination::where('parent_id', $destinationId)->get()->pluck('id')->toArray();
        $items = TravelOffer::where('type', $type)
            ->with('destinations')
            ->join('travel_offer_destinations', 'travel_offers.id', '=', 'travel_offer_destinations.travel_offer_id')
            ->whereIn('travel_offer_destinations.destination_id', $destinationIds)
            //->where('active', true)
            ->get();

        //$res = [];

        return $items;
    }
}