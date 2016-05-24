<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class GenerateUserRankings extends Command
{
    protected $signature = 'generate:userRankings';

    public function handle()
    {
        $this->line('Generating user ranking based on config.user');

        $users = User::get();

        $users->each(function ($item, $key) {
            $item->updateRanking();

        });

        $this->line('Done');
    }
}
