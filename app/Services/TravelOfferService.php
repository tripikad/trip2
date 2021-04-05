<?php

namespace App\Services;

use App\Destination;
use App\TravelOffer;
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

    /**
     * @param Request $request
     * @return array
     */
    protected function validateHotels(Request $request): array
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

    //todo
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

    //todo
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