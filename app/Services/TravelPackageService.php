<?php

namespace App\Services;

use App\Company;
use App\Destination;
use App\TravelOffer;
use App\TravelOfferHotel;
use App\Viewable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;

class TravelPackageService extends TravelOfferService
{
    /**
     * @param Destination $destination
     * @param string $size
     * @return string
     */
    public function getBackgroundImageByDestination(Destination $destination, $size = 'large'): string
    {
        $bgs = config('travel_offer_bg.package');
        if (isset($bgs[$destination->id])) {
            return asset('photos/travel_package/' . $size . '/' . $bgs[$destination->id]);
        } else if (isset($bgs[$destination->parent_id])) {
            return asset('photos/travel_package/' . $size . '/' . $bgs[$destination->parent_id]);
        } else {
            return asset('photos/travel_package/' . $size . '/' . $bgs['default']);
        }
    }

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

        $travelOffer->name = $endDestinationName . ' ' . $request->post('start_date');
        $travelOffer->slug = null;
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

        if (!$add) {
            $travelOffer->active = 1;
        }

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
     * @param Company $company
     * @param Request $request
     * @param TravelOffer $travelOffer
     * @return bool
     */
    public static function deleteTravelPackage(Company $company, Request $request, TravelOffer $travelOffer): bool
    {
        try {
            $travelOffer->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param bool $startWithTallinn
     * @return array
     */
    //todo: move to traveloffer service
    public function getCheapestOffersByCountry($startWithTallinn = true): array
    {
        $query = TravelOffer::where('type', 'package')
            ->select('travel_offers.*', 'd2.id as parentDestinationId', 'd2.name as parentDestinationName')
            ->join('destinations as d1', 'travel_offers.end_destination_id', '=', 'd1.id')
            ->join('destinations as d2', 'd1.parent_id', '=', 'd2.id')
            ->orderBy('parentDestinationName', 'ASC');
            //->where('active', true)

        if ($startWithTallinn) {
            $query->where('start_destination_id', self::DESTINATION_TALLINN_ID);
        }

        $items= $query->get();

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

    public function getListItemsByType(string $type, Request $request)
    {
        $query = TravelOffer::where('travel_offers.type', $type)
            ->select('travel_offers.*', 'd2.id as parentDestinationId', 'd2.name as parentDestinationName')
            ->join('destinations as d1', 'travel_offers.end_destination_id', '=', 'd1.id')
            ->join('destinations as d2', 'd1.parent_id', '=', 'd2.id')
            ->join('companies as c', 'c.id', '=', 'travel_offers.company_id')
            ->where('start_destination_id', $request->get('start_destination') ?? self::DESTINATION_TALLINN_ID)
            ->orderBy('travel_offers.start_date', 'ASC', 'parentDestinationName', 'ASC');
            //->where('active', true)

        if ($request->get('end_destination')) {
            $query->where('d1.id', $request->get('end_destination'))
                ->orWhere('d2.id', $request->get('end_destination'));
        }

        if ($request->get('start_date')) {
            $query->where('start_date', Carbon::parse($request->get('start_date'))->format('Y-m-d'));
        }

        if ($request->get('nights')) {
            $query->where(DB::raw('DATEDIFF(travel_offers.end_date,travel_offers.start_date)'), (int)$request->get('nights'));
        }

        return $query->paginate(10);
    }

    /**
     * @param $slug
     * @return TravelOffer|null
     */
    public function getOfferWithDestinationsBySlug($slug): ?TravelOffer
    {
        return TravelOffer::where('travel_offers.type', 'package')
            ->where('travel_offers.slug', $slug)
            ->select('travel_offers.*', 'd2.id as parentDestinationId', 'd2.name as parentDestinationName', 'd1.name as destinationName')
            ->join('destinations as d1', 'travel_offers.end_destination_id', '=', 'd1.id')
            ->join('destinations as d2', 'd1.parent_id', '=', 'd2.id')
            //->where('active', true)
            ->first();
    }

    /**
     * @param TravelOffer $offer
     * @return bool
     */
    public function addViewCount(TravelOffer $offer): bool
    {
        $user = auth()->user();
        $viewableId = (int) $offer->id;
        $viewableType = DB::getPdo()->quote(TravelOffer::class);
        $ip = request()->ip();
        $table_name = with(new Viewable())->getTable();
        $value = 1;

        if (!$ip && !$user) {
            return false;
        }

        $cache_key = 'travel_package_' . $viewableId . '_' . ($user ? $user->id : $ip);

        if (!Cache::get($cache_key)) {
            DB::insert(
                "INSERT INTO `$table_name` (`viewable_id`, `viewable_type`, `count`) 
                VALUES ($viewableId, $viewableType, $value) 
                ON DUPLICATE KEY UPDATE 
                `count`=`count` + 1"
            );

            Cache::put($cache_key, 1, config('cache.viewable.travel_package'));
        }

        return true;
    }
}