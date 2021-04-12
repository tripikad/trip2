<?php

namespace App\Services;

use App\TravelOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TravelOfferService
{
    const DESTINATION_TALLINN_ID = 829;

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
        $dbField = $end ? 'end_destination_id' : 'start_destination_id';
        $items = TravelOffer::where('type', $type)
            ->select('travel_offers.*', 'd2.id as parentDestinationId', 'd2.name as parentDestinationName', 'd1.name as destinationName')
            ->join('destinations as d1', $joinField, '=', 'd1.id')
            ->join('destinations as d2', 'd1.parent_id', '=', 'd2.id')
            ->orderBy('parentDestinationName', 'ASC', 'destinationName', 'ASC')
            //->where('active', true)
            ->get();

        $res = [];
        $usedDestinations = [];
        foreach ($items as $item) {
            $parentDestinationId = $item->parentDestinationId;
            if (!isset($res[$parentDestinationId])) {
                $res[$parentDestinationId] = [
                    'id' => $parentDestinationId,
                    'name' => $item->parentDestinationName,
                    'children' => [
                        [
                            'id' => $item->$dbField,
                            'name' => $item->destinationName
                        ]
                    ]
                ];
            } else {
                if (!in_array($item->$dbField, $usedDestinations)) {
                    $res[$parentDestinationId]['children'][] = [
                        'id' => $item->$dbField,
                        'name' => $item->destinationName
                    ];
                }

            }

            $usedDestinations[] = $item->$dbField;
        }

        return array_values($res);
    }

    /**
     * @param string $type
     * @return array
     */
    public static function getDistinctStartDestinationsByType(string $type): array
    {
        $items = TravelOffer::where('type', $type)
            ->select('travel_offers.*', 'd1.id as destinationId', 'd1.name as destinationName')
            ->join('destinations as d1', 'start_destination_id', '=', 'd1.id')
            ->orderBy('destinationName', 'ASC')
            //->where('active', true)
            ->get()->unique('destinationId')->map(function ($offer) {
                return [
                    'id' => $offer->start_destination_id,
                    'name' => $offer->destinationName
                ];
            });

        return array_values($items->toArray());
    }
}