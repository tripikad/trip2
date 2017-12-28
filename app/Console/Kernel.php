<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [

        \App\Console\Commands\ConvertOldUser::class,
        \App\Console\Commands\ConvertUrl::class,
        \App\Console\Commands\ConvertUrlTest::class,
        \App\Console\Commands\GenerateUserRankings::class,
        \App\Console\Commands\MakeComponent::class,
        \App\Console\Commands\MakeRegion::class,
        \App\Console\Commands\UserDelete::class,
        \App\Console\Commands\RemoveDuplicates::class,
        \App\Console\Commands\GenerateSitemap::class,
        \App\Console\Commands\ConvertMissingContent::class,
        \App\Console\Commands\ConvertSearchable::class,
        \App\Console\Commands\DisableOldShortNews::class,
        \App\Console\Commands\ForumMiscTopic::class,
        \App\Console\Commands\Newsletter::class,
        \App\Console\Commands\GenerateKeywords::class,
        \App\Console\Commands\GenerateSimilars::class,

    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('generate:userRankings')
            ->dailyAt('04:00');

        $schedule->command('sitemap:generate')
            ->dailyAt('05:00');

        $schedule->command('search:index')
            ->cron('59 * * * *');

        $schedule->command('search:index --optimize')
            ->dailyAt('05:55');

        $schedule->command('newsletter:send')
            ->cron('*/5 * * * *');

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
