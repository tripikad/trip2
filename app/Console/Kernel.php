<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [

        \App\Console\Commands\GenerateUserRankings::class,
        \App\Console\Commands\ConvertOldUser::class,
        \App\Console\Commands\ConvertUrl::class,
        \App\Console\Commands\ConvertUrlTest::class,

    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('generate:userRankings')
            ->dailyAt('04:00');
    }
}
