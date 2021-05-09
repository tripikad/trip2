<?php

namespace App\Console\Commands;

use App\TravelOffer;
use App\TravelOfferHotel;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Destination;

class ReisiparadiisSync extends Command
{
    protected $company_id = null;

    protected $signature = 'reisiparadiis:sync';

    protected $description = 'Sync with Reisiparadiis offers';

    private $endpage = 1;

    private $endpoint = 'https://www.reisiparadiis.ee/wp-json/wp/v2/reisid?page=[PAGE]&token=[TOKEN]';

    private $cityMapping = [
        //'Dubai-Jebel Ali' => 'Dubai',
        //'Dubai-City' => 'Dubai',
        //'Sharjah' => 'Dubai',
        "Tenerife North" => 'Tenerife',
        "Tenerife Sur" => 'Tenerife',
        "Incekum - Alanya" => 'Alanya',
    ];

    protected $startDestination = null;

    protected $cities = [];
    protected $cityNames = [];

    public function __construct()
    {
        parent::__construct();
        $this->company_id = env('REISIPARADIIS_COMPANY_ID');
        $token = env('REISIPARADIIS_TOKEN');
        $this->endpoint = str_replace('[TOKEN]', $token, $this->endpoint);
        $this->startDestination = Destination::where('name', 'Tallinn')->first();
        $cities = [];
        $cityNames = [];
        Destination::where('depth', 2)->get()->map(function($destination) use (&$cities, &$cityNames) {
            $cities[mb_strtoupper($destination->name)] = [
                'id' => $destination->id,
                'name' => $destination->name
            ];

            $cityNames[$destination->id] = $destination->name;
        });

        $this->cities = $cities;
        $this->cityNames = $cityNames;
        //print_r($this->cities);
    }

    private function getCity($city)
    {
        if (isset($this->cityMapping[$city])) {
            return $this->cityMapping[$city];
        }

        return $city;
    }

    /*private function getEndDestinations($data)
    {
        $hotels = $data['hotels'];
        $additionalData = $hotels[0];
        $city = $this->getCity($additionalData['linn']);
        $endDestinations[] = Destination::whereIn('name', [$data['destination'], $city])->get()->pluck('id')->toArray();

        return $endDestinations;
    }*/

    private function getEndDestinationByHotelData($data)
    {
        $city = mb_strtoupper($this->getCity($data['linn']));
        if (isset($this->cities[$city]) && $this->cities[$city]) {
            return $this->cities[$city];
        }

        return null;
    }

    private function getHotelRatingFromName($name)
    {
        $exploded = explode(' ', $name);
        $lastPart = end($exploded);
        $rating = intval(only_numbers($lastPart));

        return $rating ?? '';
    }

    /*private function deleteOfferByExtId($id)
    {
        $offer = Offer::where('ext_id', $id)->first();
        $offer->startDestinations()->detach();
        $offer->endDestinations()->detach();

        $offer->delete();
    }*/

    private function clearContent($content)
    {
        $content = strip_tags($content);
        $content = str_replace('Warning:  Invalid argument supplied for foreach() in /data03/virt23976/domeenid/www.reisiparadiis.ee/htdocs/wp-content/themes/reisiparadiis/functions.php on line 1224', '', $content);
        $content = str_replace('Warning:  array_filter() expects parameter 1 to be array, null given in /data03/virt23976/domeenid/www.reisiparadiis.ee/htdocs/wp-content/themes/reisiparadiis/functions.php on line 1221', '', $content);
        $content = trim($content);

        return json_decode($content, true);
    }

    private function getLowestHotelsPrice($hotels)
    {
        $price = $hotels[0]['price'];
        foreach ($hotels as $hotel) {
            if ($hotel['price'] < $price) {
                $price = $hotel['price'];
            }
        }

        return $price;
    }

    public function handle()
    {
        $this->info("\nStarting sync\n");

        /*$existingOffers = Offer::whereNotNull('ext_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['ext_id'] => $item['ext_date_time']->format('Y-m-d H:i:s')];
            }, collect())
            ->toArray();*/

        while($this->endpage) {
            $endpoint = str_replace('[PAGE]', $this->endpage, $this->endpoint);

            try {
                //$content = json_decode(file_get_contents($endpoint), true);

                //$content = file_get_contents($endpoint);
                $content = $this->clearContent(file_get_contents($endpoint));

                if ($content && count($content) && isset($content[0]['id'])) {
                    foreach ($content as $data) {
                        $extId = $data['id'];
                        $hotels = $data['hotels'];

                        if (!$hotels) {
                            continue;
                        }

                        $hotelData = $hotels[0];
                        $days = intval($hotelData['ood']);

                        $hotelRows = [];
                        foreach ($hotels as $hotel) {
                            $destination = $this->getEndDestinationByHotelData($hotel);
                            if (!$destination) {
                                $this->info("\nDestination not found: {$data['destination']} / {$hotel['linn']}\n");
                            } else {
                                $hotelRows[$destination['id']][] = [
                                    'name' => $hotel['hotelli_nimi'],
                                    'type' => $hotel['toatuup'],
                                    'rating' => $this->getHotelRatingFromName($hotel['hotelli_nimi']),
                                    'price' => (string)$hotel['hind']
                                ];
                            }
                        }

                        if (!$hotelRows) {
                            continue;
                        }

                        $start = Carbon::createFromFormat('Ymd', $data['date_from']);
                        $end = clone $start;
                        $end->addDays($days);

                        foreach ($hotelRows as $destinationId => $hotels) {
                            $name = $this->cityNames[$destinationId] . ' ' . $start->format('d.m.Y');
                            $price = $this->getLowestHotelsPrice($hotels);

                            $offer = new TravelOffer();
                            $offer->company_id = $this->company_id;
                            $offer->start_destination_id = $this->startDestination->id;
                            $offer->end_destination_id = $destinationId;
                            $offer->type = 'package';
                            $offer->name = $name;
                            $offer->start_date = $start;
                            $offer->end_date = $end;
                            $offer->active = 1;
                            $offer->price = $price;
                            $offer->ext_id = $extId;
                            $offer->ext_name = 'reisiparadiis';
                            $offer->save();

                            foreach ($hotels as $hotel) {
                                $offerHotel = new TravelOfferHotel();
                                $offerHotel->travel_offer_id = $offer->id;
                                $offerHotel->name = $hotel['name'];
                                $offerHotel->price = $hotel['price'];
                                $offerHotel->star = $hotel['rating'];
                                $offerHotel->accommodation = $hotel['type'];
                                $offerHotel->save();
                            }
                        }
                    }

                    $this->endpage ++;
                } else {
                    $this->endpage = null;
                    break;
                }

            } catch (\Exception $exeption) {
                $this->endpage = null;
                $this->error($exeption->getMessage());
                break;
            }
        }

        $this->info("\nDONE\n");

    }
}
