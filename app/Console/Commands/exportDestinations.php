<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class exportDestinations extends Command
{
    protected $signature = 'export:destinations';

    public function handle()
    {

        $countries_unknown = collect([
            ['Holland' => 'NL'],
            ['Iirimaa' => 'IE'],
            ['Lõuna-Aafrika Vabariik' => 'ZA'],
            ['Tansaania' => 'TZ'],
            ['Šveits' => 'CH'],
            ['Uus-Meremaa' => 'NZ'],
            ['Jordaania' => 'JO'],
            ['Seišellid' => ''],
            ['Kambodža' => ''],
            ['Paraguai' => ''],
            ['Küpros' => ''],
            ['Jamaika' => ''],
            ['Tšiili' => ''],
            ['Fidži' => ''],
            ['Saalomoni saared' => ''],
            ['Vatikan' => ''],
            ['Bosnia ja Hertsegoviina' => ''],
            ['Tadžikistan' => ''],
            ['Kanaari saared' => ''],
            ['Kolumbia' => ''],
            ['Havai' => ''],
            ['Aserbaidžaan' => ''],
            ['Tšehhi' => ''],
            ['Jugoslaavia' => ''],
            ['Galapagos' => ''],
            ['Elevandiluurannik' => ''],
            ['Suurbritannia' => ''],
            ['Taivan' => ''],
            ['Hollandi Antillid' => ''],
            ['Lõuna-Korea' => ''],
            ['Surinam' => ''],
            ['Sambia' => ''],
            ['Sao Tome ja Principe' => ''],
            ['Kõrgõzstan' => ''],
            ['Reunion' => ''],
            ['Paapua Uus-Guinea' => ''],
            ['Makedoonia' => ''],
            ['Tšaad' => ''],
            ['Kesk-Aafrika Vabariik' => ''],
            ['Kongo' => ''],
            ['Kongo Demokraatlik Vabariik' => ''],
            ['Angoola' => ''],
            ['Komoorid' => ''],
            ['Bahama' => ''],
            ['Uruguai' => ''],
            ['Ida-Timor' => ''],
            ['Kookosesaared' => ''],
            ['Mikroneesia' => ''],
            ['Saint-Pierre ja Miquelon' => ''],
            ['Saint Vincent ja Grenadiinid' => ''],
            ['Marshalli saared' => ''],
            ['Somaalimaa' => ''],
            ['Chennai' => ''],
        ]);
        
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
        
        //dd($countries_et);
        
        //dd($countries->where('name.common', 'Aruba')->first());
        
        $destinations = \App\Destination::get();
        $no = [];

        foreach ($destinations as $destination) {
            if ($destination->getLevel() == 1) {
                if ($country = $countries->where('name.common', $destination->name)->first()) {
                   /*
                   $this->line(
                        $destination->name . ',' 
                        . $country->cca2 . ',' 
                        . $country->cca3 . ',' 
                        . $country->currency[0] . ',' 
                        . $country->area
                    );*/
                } else if ($country_et = $countries_et->where('countryName', $destination->name)->first()) {
                    //$this->line($destination->name);
                } else {
                    //$this->line($destination->name . ',,,,');
                    $this->line("['$destination->name' => ''],");
                }
            }
        }

    }
}

/*

{#889
  +"name": {#897
    +"common": "Aruba"
    +"official": "Aruba"
    +"native": {#904
      +"nld": {#899
        +"official": "Aruba"
        +"common": "Aruba"
      }
      +"pap": {#902
        +"official": "Aruba"
        +"common": "Aruba"
      }
    }
  }
  +"tld": array:1 [
    0 => ".aw"
  ]
  +"cca2": "AW"
  +"ccn3": "533"
  +"cca3": "ABW"
  +"cioc": "ARU"
  +"currency": array:1 [
    0 => "AWG"
  ]
  +"callingCode": array:1 [
    0 => "297"
  ]
  +"capital": "Oranjestad"
  +"altSpellings": array:1 [
    0 => "AW"
  ]
  +"region": "Americas"
  +"subregion": "Caribbean"
  +"languages": {#898
    +"nld": "Dutch"
    +"pap": "Papiamento"
  }
  +"translations": {#890
    +"deu": {#891
      +"official": "Aruba"
      +"common": "Aruba"
    }
    +"fra": {#888
      +"official": "Aruba"
      +"common": "Aruba"
    }
    +"hrv": {#903
      +"official": "Aruba"
      +"common": "Aruba"
    }
    +"ita": {#896
      +"official": "Aruba"
      +"common": "Aruba"
    }
    +"jpn": {#905
      +"official": "アルバ"
      +"common": "アルバ"
    }
    +"nld": {#906
      +"official": "Aruba"
      +"common": "Aruba"
    }
    +"por": {#907
      +"official": "Aruba"
      +"common": "Aruba"
    }
    +"rus": {#908
      +"official": "Аруба"
      +"common": "Аруба"
    }
    +"spa": {#909
      +"official": "Aruba"
      +"common": "Aruba"
    }
    +"fin": {#910
      +"official": "Aruba"
      +"common": "Aruba"
    }
  }
  +"latlng": array:2 [
    0 => 12.5
    1 => -69.96666666
  ]
  +"demonym": "Aruban"
  +"landlocked": false
  +"borders": []
  +"area": 180
}

array:18 [
  "countryCode" => "AW" // cca2
  "countryName" => "Aruba" 
  "isoNumeric" => "533" // ccn3
  "isoAlpha3" => "ABW" // cca3
  "fipsCode" => "AA"
  "continent" => "NA"
  "continentName" => "North America"
  "capital" => "Oranjestad"
  "areaInSqKm" => "193.0"
  "population" => "71566"
  "currencyCode" => "AWG"
  "languages" => "nl-AW,es,en"
  "geonameId" => "3577279"
  "west" => "-70.0644737196045"
  "north" => "12.623718127152925"
  "east" => "-69.86575120104982"
  "south" => "12.411707706190716"
  "postalCodeFormat" => []
]
*/