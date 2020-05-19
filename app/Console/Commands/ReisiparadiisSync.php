<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Offer;
use App\User;
use App\Destination;
use PhpParser\Node\Scalar\String_;

class ReisiparadiisSync extends Command
{
    const USER_ID = 7311682; //reisiparadiis user ID

    protected $signature = 'reisiparadiis:sync';

    protected $description = 'Sync with Reisiparadiis offers';

    private $endpage = 1;

    private $endpoint = 'https://www.reisiparadiis.ee/wp-json/wp/v2/reisid?page=[PAGE]&token=[TOKEN]';

    private $cityMapping = [
        'Dubai-Jebel Ali' => 'Dubai',
        'Dubai-City' => 'Dubai',
        'Sharjah' => 'Dubai',
        'Tenerife North' => 'Tenerife',
        'Tenerife Sur' => 'Tenerife',
        'Incekum - Alanya' => 'Alanya',
    ];

    protected $startDestination = null;

    public function __construct()
    {
        parent::__construct();
        $token = env('REISIPARADIIS_TOKEN');
        $this->endpoint = str_replace('[TOKEN]', $token, $this->endpoint);
        $this->startDestination = Destination::where('name', 'Tallinn')->first();
    }

    private function getCity($city)
    {
        if (isset($this->cityMapping[$city])) {
            return $this->cityMapping[$city];
        }

        return $city;
    }

    private function getEndDestinations($data)
    {
        $hotels = $data['hotels'];
        $additionalData = $hotels[0];
        $city = $this->getCity($additionalData['linn']);
        $endDestinations[] = Destination::whereIn('name', [$data['destination'], $city])->get()->pluck('id')->toArray();

        return $endDestinations;
    }

    private function getHotelRatingFromName($name)
    {
        $exploded = explode(' ', $name);
        $lastPart = end($exploded);
        $rating = intval(only_numbers($lastPart));

        return $rating ?? '';
    }

    private function deleteOfferByExtId($id)
    {
        $offer = Offer::where('ext_id', $id)->first();
        $offer->startDestinations()->detach();
        $offer->endDestinations()->detach();

        $offer->delete();
    }

    public function handle()
    {
        $this->info("\nStarting sync\n");

        $existingOffers = Offer::whereNotNull('ext_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['ext_id'] => $item['ext_date_time']->format('Y-m-d H:i:s')];
            }, collect())
            ->toArray();

        while($this->endpage) {
            $endpoint = str_replace('[PAGE]', $this->endpage, $this->endpoint);

            try {
                $content = json_decode(file_get_contents($endpoint), true);

                if ($content && count($content) && isset($content[0]['id'])) {
                    foreach ($content as $data) {
                        $id = $data['id'];

                        if (isset($existingOffers[$id])) {
                            $updatedDateTime = $existingOffers[$id];
                            unset($existingOffers[$id]);

                            //nothing changed, skip it
                            if ($updatedDateTime === $data['last_update']) {
                                continue;
                            } else {
                                $this->deleteOfferByExtId($id);
                            }
                        }

                        $hotels = $data['hotels'];
                        $hotelData = $hotels[0];

                        $endDestinations = $this->getEndDestinations($data);
                        if (!$endDestinations || !count($endDestinations)) {
                            $this->info("\nDestination not found: {$data['destination']} / {$hotelData['linn']}\n");
                            continue;
                        }

                        $days = intval($hotelData['ood']);
                        $start = Carbon::createFromFormat('Ymd', $data['date_from']);
                        $end = clone $start;
                        $end->addDays($days);

                        $hotelData = [];
                        foreach ($hotels as $hotel) {
                            $hotelData[] = [
                                'name' => $hotel['hotelli_nimi'],
                                'type' => $hotel['toatuup'],
                                'rating' => $this->getHotelRatingFromName($hotel['hotelli_nimi']),
                                'price' => (String)$hotel['hind']
                            ];
                        }

                        $res = [
                            'user_id' => self::USER_ID,
                            'title' => $data['title'],
                            'style' => 'package',
                            'start_at' => $start,
                            'end_at' => $end,
                            'status' => 1,
                            'ext_id' => $id,
                            'ext_date_time' => $data['last_update'],
                            'data' => [
                                'price' => $data['price_from'],
                                'guide' => '',
                                'size' => '',
                                'description' => $data['description'],
                                'url' => $data['url'],
                                'accommodation' => '',
                                'included' => '',
                                'notincluded' => '',
                                'extras' => '',
                                'flights' => true,
                                'transfer' => true,
                                'hotels' => $hotelData
                            ]
                        ];

                        $offer = Offer::create(
                            collect($res)->toArray()
                        );

                        $offer->startDestinations()->attach(
                            collect([$this->startDestination->id])->mapWithKeys(function ($key) {
                                return [$key => ['type' => 'start']];
                            })
                        );

                        $offer->endDestinations()->attach(
                            collect($endDestinations)->mapWithKeys(function ($value) {
                                return [$value[0] => ['type' => 'end']];
                            })
                        );
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

        if ($existingOffers && count($existingOffers)) {
            foreach ($existingOffers as $id => $value) {
                $this->deleteOfferByExtId($id);
            }
        }

        $this->info("\nDONE\n");

    }
}
