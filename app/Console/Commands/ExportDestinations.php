<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExportDestinations extends Command
{
    protected $signature = 'export:destinations';

    public function handle()
    {

        // Countries we can not detect country code by name

        $countries_unknown = [
            'Holland' => 'NL',
            'Iirimaa' => 'IE',
            'Lõuna-Aafrika Vabariik' => 'ZA',
            'Tansaania' => 'TZ',
            'Šveits' => 'CH',
            'Uus-Meremaa' => 'NZ',
            'Jordaania' => 'JO',
            'Seišellid' => 'SC',
            'Kambodža' => 'KH',
            'Paraguai' => 'PY',
            'Küpros' => 'CY',
            'Jamaika' => 'JM',
            'Tšiili' => 'CL',
            'Fidži' => 'FJ',
            'Saalomoni saared' => 'SB',
            'Vatikan' => 'VA',
            'Bosnia ja Hertsegoviina' => 'BA',
            'Tadžikistan' => 'TJ',
            // 'Kanaari saared' => '',
            'Kolumbia' => 'CO',
            // 'Havai' => '',
            'Aserbaidžaan' => 'AZ',
            'Tšehhi' => 'CZ',
            //'Jugoslaavia' => '',
            //'Galapagos' => '',
            'Elevandiluurannik' => 'CI',
            'Suurbritannia' => 'GB',
            'Taivan' => 'TW',
            //'Hollandi Antillid' => '',
            'Lõuna-Korea' => 'KR',
            'Surinam' => 'SR',
            'Sambia' => 'ZM',
            'Sao Tome ja Principe' => 'ST',
            'Kõrgõzstan' => 'KG',
            //'Reunion' => '',
            'Paapua Uus-Guinea' => 'PG',
            'Makedoonia' => 'MK',
            'Tšaad' => 'TD',
            'Kesk-Aafrika Vabariik' => 'CF',
            'Kongo' => 'CG',
            'Kongo Demokraatlik Vabariik' => 'CD',
            'Angoola' => 'AO',
            'Komoorid' => 'KM',
            'Bahama' => 'BS',
            'Uruguai' => 'UY',
            'Ida-Timor' => 'TL',
            'Kookosesaared' => 'CC',
            'Mikroneesia' => 'FM',
            'Saint-Pierre ja Miquelon' => 'PM',
            'Saint Vincent ja Grenadiinid' => 'VC',
            'Marshalli saared' => 'MH',
            //'Somaalimaa' => '',
            //'Chennai' => '',
        ];

        // Get the datasets

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

        // Get the destinations

        $destinations = \App\Destination::orderBy('name')->get();

        // For each 1-level destination (a country) try to detect its country code,
        // either by English or Estonian name
        // If no match is found, fall back to $countries_unknown map

        $destinations = \App\Destination::orderBy('name')->get();

        $results = [];

        foreach ($destinations as $destination) {
            if ($destination->getLevel() == 1) {
                if ($country = $countries->where('name.common', $destination->name)->first()) {
                    $results[$destination->id] = ['code' => $country->cca2];
                } elseif ($country_et = $countries_et->where('countryName', $destination->name)->first()) {
                    $results[$destination->id] = ['code' => $country_et['countryCode']];
                } elseif (in_array($destination->name, array_keys($countries_unknown))) {
                    $results[$destination->id] = ['code' => $countries_unknown[$destination->name]];
                }
            }
        }

        // Output config file header

        $this->line("<?php\n\nreturn [");

        // Go through the results and popluate the data

        foreach ($results as $id => $data) {
            $row = array_merge($results[$id], [
                'capital' => ($id == 331 || $id == 931) ? '' : $countries_et->where('countryCode', $data['code'])->first()['capital'],
                'area' => $countries->where('cca2', $data['code'])->first()->area,
                'population' => $countries_et->where('countryCode', $data['code'])->first()['population'],
                'callingCode' => $countries->where('cca2', $data['code'])->first()->callingCode[0],
                'currencyCode' => $countries_et->where('countryCode', $data['code'])->first()['currencyCode'],
            ]);

            // Convert the result to short array syntax and output it

            $this->line("$id => ".str_replace(['array (', ')'], ['[', ']'], var_export($row, true)).',');
        }

        // Output config file footer

        $this->line('];');
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
