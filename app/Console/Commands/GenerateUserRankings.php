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

        User::chunk(200, function ($users) {
            foreach ($users as $user) {
                $user->updateRanking();
            }
        });

        $this->line('Done');
    }
}
