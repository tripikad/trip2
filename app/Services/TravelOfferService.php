<?php

namespace App\Services;

use App\Company;
use App\Destination;
use App\TravelOffer;
use App\TravelOfferHotel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TravelOfferService
{
    /**
     * @return array
     */
    public function getAccommodationOptions(): array
    {
        return [
            [
                'id' => null,
                'name' => 'Määramata'
            ],
            [
                'id' => 'AI',
                'name' => 'All inclusive (AI)'
            ],
            [
                'id' => 'FB',
                'name' => 'Täispansion (FB)'
            ],
            [
                'id' => 'HB',
                'name' => 'Poolpansion (HB)'
            ],
            [
                'id' => 'BB',
                'name' => 'Bed & Breakfast (BB)'
            ],
            [
                'id' => 'BO',
                'name' => 'Ilma toitlustuseta (BO)'
            ],
        ];
    }

    protected function validateTravelPackage()
    {

    }

    private function _validateHotels(\Illuminate\Validation\Validator $validator, Request $request)
    {
        $hotelRules = [
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'star' => 'nullable|integer',
            'link' => 'nullable|url',
            'accommodation' => [
                'nullable',
                Rule::in(array_column($this->getAccommodationOptions(), 'id'))
            ]
        ];

        $hotels = $request->post('hotel');
        $errors = [];
        if ($hotels && count($hotels)) {
            foreach ($hotels as $key => $hotel) {
                $hotelValidator = Validator::make($hotel, $hotelRules);
                if ($hotelValidator->fails()) {
                    $errors[$key] = $hotelValidator->errors()->getMessages();
                }
            }
        }

        return $errors;
    }

    public function storeTravelPackage(Company $company, Request $request)
    {
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
            $hotelErrors = $this->_validateHotels($validator, $request);
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

        $travelOffer = new TravelOffer();
        $travelOffer->company_id = $company->id;
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

    public function updateTravelPackage(TravelOffer $travelOffer, Request $request)
    {
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
            $hotelErrors = $this->_validateHotels($validator, $request);
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

        $endDestinationName = $destinations[$request->post('destination')];
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

        $travelOffer->hotels()->delete();
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

    public function getGridItemsByType(string $type)
    {
        $items = TravelOffer::where('type', $type)
            ->with('destinations')
            //->where('active', true)
            ->get();

        $res = [];
        foreach ($items as $item) {
            $destination = $item->destinations->first();
            $parentDestination = $destination::find($destination->parent_id);

            if (!isset($res[$parentDestination->id])) {
                $res[$parentDestination->id] = [
                    'name' => $parentDestination->name,
                    'price' => $item->price
                ];
            } else {
                if ($item->price < $res[$parentDestination->id]['price']) {
                    $res[$parentDestination->id]['price'] = $item->price;
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