<?php

namespace App\Console\Commands;

use DB;

class ConvertUrlTest extends ConvertBase
{
    protected $signature = 'convert:urltest';

    public function handle()
    {

        $csv = array_map('str_getcsv', file(base_path().'/app/Console/Commands/ConvertUrlTest.csv'));

        array_walk($csv, function(&$a) use ($csv) {
          $a = array_combine($csv[0], $a);
        });
        array_shift($csv);

        collect($csv)->take(5)->each(function($row) {

            $request = \Request::create($row['URL'], 'GET');
            $response = \Route::dispatch($request);

            if (in_array($response->status(), [200, 301])) {

                $this->info($row['Response Code'].' -> '.$response->status());
        
            } else {

            $this->error($row['Response Code'].' -> '.$response->status().' '.$row['URL']);

            }

        });

    }

};