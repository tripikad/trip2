<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  protected $commands = [];

  protected function schedule(Schedule $schedule)
  {
    $schedule->command('generate:userRankings')->dailyAt('04:00');

    $schedule->command('sitemap:generate')->dailyAt('05:00');

    $schedule->command('search:index')->cron('0 */4 * * *');

    $schedule->command('search:index --optimize')->dailyAt('05:55');

    //$schedule->command('newsletter:send --check-newsletters')
    //    ->cron('*/10 * * * *');

    //$schedule->command('newsletter:send')
    //    ->cron('*/5 * * * *');
  }

  /**
   * Register the Closure based commands for the application.
   *
   * @return void
   */
  protected function commands()
  {
    $this->load(__DIR__ . '/Commands');

    require base_path('routes/console.php');
  }
}
