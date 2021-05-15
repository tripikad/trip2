<?php

namespace App\Console\Commands;

use App\TravelOffer;
use App\TravelOfferHotel;
use App\Viewable;
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
        'Dubai-Jebel Ali' => 'Dubai',
        'Dubai-City' => 'Dubai',
        'Sharjah' => 'Dubai',
        "Tenerife North" => 'Tenerife',
        "Tenerife Sur" => 'Tenerife',
        'Rhodos-Kallithea/Faliraki' => 'Rhodos',
        'Rhodos-Ialysos/Rhodos' => 'Rhodos',
        'Rhodos-Lindos' => 'Rhodos',
        'Rhodos-Fanes' => 'Rhodos',
        'Rhodes-Afandou' => 'Rhodos',
        "Kreeta-Iraklion" => 'Kreeta',
        "Kreeta-Rethymno" => 'Kreeta',
        "Sunny Beach" => 'Päikeserannik',
        'St.Vlas' => 'Päikeserannik',
        'Nessebar' => 'Päikeserannik',
        'Golden Sands' => 'Kuldsed liivad',
        "Incekum - Alanya" => 'Alanya',
        'BELDIBI' => 'Alanya',
        "KEMER CENTER" => 'Kemer',
        'OKURCALAR' => 'Alanya',
        'KIRIS' => 'Kemer',
        'Side' => 'Antalya',
        'MANAVGAT' => 'Antalya',
        'SIDE CITY' => 'Antalya',
        'CAMYUVA' => 'Kemer',
        'KONAKLI' => 'Alanya',
        'MAHMUTLAR' => 'Alanya',
        'Adjara - Kobuleti' => 'Batumi',
        'Adjara / Batumi' => 'Batumi',

    ];

    protected $destinationTallinn = null;
    //protected $destinationRiga = null;
    protected $cities = [];
    protected $cityNames = [];

    public function __construct()
    {
        parent::__construct();
        $this->company_id = env('REISIPARADIIS_COMPANY_ID');
        $token = env('REISIPARADIIS_TOKEN');
        $this->endpoint = str_replace('[TOKEN]', $token, $this->endpoint);
        $this->destinationTallinn = Destination::where('name', 'Tallinn')->first();
        //$this->destinationRiga = Destination::where('name', 'Riia')->first();
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
    }

    private function deleteOffers()
    {
        $viewableIds = TravelOffer::where('ext_name', 'reisiparadiis')
            ->has('views')
            ->get()
            ->pluck('views.viewable_id');

        TravelOffer::where('ext_name', 'reisiparadiis')->delete();
        if ($viewableIds) {
            Viewable::whereIn('viewable_id', $viewableIds)->where('viewable_type', TravelOffer::class)->delete();
        }
    }

    private function getCity($city)
    {
        if (isset($this->cityMapping[$city])) {
            return $this->cityMapping[$city];
        }

        return $city;
    }

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

    private function getIncluded()
    {
        return '
        <ul>
            <li>Edasi-tagasi lennupiletid otselennule Tallinnast</li>
            <li>Majutus valitud hotellis koos toitlustusega vastavalt hotelli konseptsioonile</li>
            <li>Transfeer lennujaam - hotell - lennujaam</li>
            <li>Reisiesindaja teenused kohapeal</li>
            <li>Äraantav pagas + käsipagas</li>
        </ul>
        ';
    }

    public function handle()
    {
        $this->info("\nStarting sync\n");

        $this->deleteOffers();

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

                        $start = Carbon::createFromFormat('Ymd', $data['date_from']);
                        if ($start < Carbon::today()) {
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

                        $end = clone $start;
                        $end->addDays($days);

                        foreach ($hotelRows as $destinationId => $hotels) {
                            $name = $this->cityNames[$destinationId] . ' ' . $start->format('d.m.Y');
                            $price = $this->getLowestHotelsPrice($hotels);

                            $offer = new TravelOffer();
                            $offer->company_id = $this->company_id;
                            $offer->start_destination_id = $this->destinationTallinn->id;
                            $offer->end_destination_id = $destinationId;
                            $offer->type = 'package';
                            $offer->name = $name;
                            $offer->start_date = $start;
                            $offer->end_date = $end;
                            $offer->active = 1;
                            $offer->price = $price;
                            $offer->included = $this->getIncluded();
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
