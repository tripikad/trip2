<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Newsletter extends Command
{
    protected $signature = 'newsletter:send';

    public function handle()
    {
        // selekteeri uudiskirja tüübid, mis on vaja välja saata

        // Vaata kas tulevikus väljasaadetavate uudiskirjade sisu eksisteerib, kui ei siis lisa tavapärane layout
    }
}
