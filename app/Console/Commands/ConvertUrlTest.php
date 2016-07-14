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

        collect($csv)->take(10)->each(function($row) {
            
            $request = \Request::create($row['URL'], 'GET');
            $response = \Route::dispatch($request);

            $this->line($row['Response Code'].' -> '.$response->status());
        
        });

    }

};