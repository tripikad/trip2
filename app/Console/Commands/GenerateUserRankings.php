<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

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
