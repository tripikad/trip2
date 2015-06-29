<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [

        \App\Console\Commands\ConvertAll::class,
        \App\Console\Commands\ConvertBlogs::class,
        \App\Console\Commands\ConvertBuysells::class,
        \App\Console\Commands\ConvertExpats::class,
        \App\Console\Commands\ConvertFlights::class,
        \App\Console\Commands\ConvertForums::class,
        \App\Console\Commands\ConvertInternal::class,
        \App\Console\Commands\ConvertMiscs::class,
        \App\Console\Commands\ConvertNews::class,
        \App\Console\Commands\ConvertOffers::class,
        \App\Console\Commands\ConvertPhotos::class,
        \App\Console\Commands\ConvertTerms::class,
        \App\Console\Commands\ConvertTravelmates::class,

        \App\Console\Commands\StatsAccess::class,
        \App\Console\Commands\StatsContent::class,
        \App\Console\Commands\StatsFlag::class,
        \App\Console\Commands\StatsFlagDetails::class,
        \App\Console\Commands\StatsGeneral::class,
        \App\Console\Commands\StatsMessages::class,
        \App\Console\Commands\StatsTerms::class,
        \App\Console\Commands\StatsUsersNew::class,
        \App\Console\Commands\StatsUsersOld::class,

    ];

}
