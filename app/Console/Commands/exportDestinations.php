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
        
        //dump($countries->where('name.common', 'Aruba'));
        $destinations = \App\Destination::get();

        foreach ($destinations as $destination) {
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
