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

    /**
     * @param string $type
     * @param bool $end
     * @return array
     */
    public static function getAvailableDestinationsByType(string $type, bool $end = true): array
    {
        $joinField = $end ? 'travel_offers.end_destination_id' : 'travel_offers.start_destination_id';
        $items = TravelOffer::where('type', $type)
            ->select('travel_offers.*', 'd2.id as parentDestinationId', 'd2.name as parentDestinationName', 'd1.name as destinationName')
            ->join('destinations as d1', $joinField, '=', 'd1.id')
            ->join('destinations as d2', 'd1.parent_id', '=', 'd2.id')
            ->orderBy('parentDestinationName', 'ASC', 'destinationName', 'ASC')
            //->where('active', true)
            ->get();

        $res = [];
        foreach ($items as $item) {
            $parentDestinationId = $item->parentDestinationId;
            if (!isset($res[$parentDestinationId])) {
                $res[$parentDestinationId] = [
                    'id' => $parentDestinationId,
                    'name' => $item->parentDestinationName,
                    'children' => [
                        [
                            'id' => $item->start_destination_id,
                            'name' => $item->destinationName
                        ]
                    ]
                ];
            } else {
                $res[$parentDestinationId]['children'][] = [
                    'id' => $item->start_destination_id,
                    'name' => $item->destinationName
                ];
            }
        }

        return $res;
    }
}