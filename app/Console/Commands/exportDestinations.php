<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class exportDestinations extends Command
{
    protected $signature = 'export:destinations';

    public function handle()
    {
        $client = new \GuzzleHttp\Client();

        $contents = $client
            ->get('https://raw.githubusercontent.com/mledoze/countries/master/dist/countries.json')
            ->getBody()
            ->getContents();
        $countries = collect(json_decode($contents));

        $contents_et = $client
            ->get('http://api.geonames.org/countryInfo?lang=et&username=kristjanjansen')
            ->getBody()
            ->getContents();
        $countries_et = collect(json_decode(json_encode(simplexml_load_string($contents_et)), true)['country']);
        dd($countries_et->first());

        // 

        //dump($countries->where('name.common', 'Aruba'));
        $destinations = \App\Destination::get();

        foreach ($destinations as $destination) {
            if ($destination->getLevel() == 1) {
            if ($country = $countries->where('name.common', $destination->name)->first()) {
               $this->line(
                    $destination->name . ',' 
                    . $country->cca2 . ',' 
                    . $country->cca3 . ',' 
                    . $country->currency[0] . ',' 
                    . $country->area
                );
            } else {
                $this->line($destination->name . ',,,,');
            }
            }
        }
    }
}
