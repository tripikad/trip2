<?php

namespace App\Console\Commands;

class ConvertUrlTest extends ConvertBase
{
    protected $signature = 'convert:urltest {baseurl}';

    public function handle()
    {
        $csv = array_map('str_getcsv', file(base_path().'/app/Console/Commands/ConvertUrlTest.csv'));

        array_walk($csv, function (&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv);

        $this->line(count($csv).' items');

        collect($csv)->slice(0, 6000)->each(function ($row, $key) {
            $url = str_replace('http://trip.ee/', '', $row['URL']);

            $response = $this->client->head($this->argument('baseurl').'/'.$url, [
                'exceptions' => false,
                'allow_redirects' => false,
            ]);

            $code = $response->getStatusCode();

            $message = $key.'  '.$row['Response Code'].' -> '.$code.' '.$url;

            $type = in_array($code, [200, 301]) ? 'info' : 'error';

            $this->$type($message);

        });
    }
}
