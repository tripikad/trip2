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
            'destination' => [
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

        $selectedDestinationName = $destinations[$request->post('destination')];

        $travelOffer = new TravelOffer();
        $travelOffer->company_id = $company->id;
        $travelOffer->name = $selectedDestinationName . ' ' . $request->post('start_date');
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

        $travelOffer->destinations()->attach($request->post('destination'));

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
            'destination' => [
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

        $selectedDestinationName = $destinations[$request->post('destination')];
        $travelOffer->name = $selectedDestinationName . ' ' . $request->post('start_date');
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

        $travelOffer->destinations()->sync($request->post('destination'));

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
}