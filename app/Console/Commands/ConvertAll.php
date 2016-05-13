<?php

namespace App\Console\Commands;

class ConvertAll extends ConvertBase
{
    protected $signature = 'convert:all';

    public function handle()
    {
        $this->call('convert:terms');

        $this->call('convert:blogs');
        $this->call('convert:buysells');
        $this->call('convert:expats');
        $this->call('convert:flights');
        $this->call('convert:forums');
        $this->call('convert:internal');
        $this->call('convert:miscs');
        $this->call('convert:news');

        // $this->call('convert:offers');

        $this->call('convert:photos');
        $this->call('convert:static');
        $this->call('convert:travelmates');

        $this->call('convert:follows');
        $this->call('convert:messages');

        $this->call('convert:users');

        $this->call('convert:indexAliases');
    }
}
