<?php namespace App\Console\Commands;

use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StatsBase extends Command
{

    protected $connection = 'trip';

    protected $contentTypes = [
        'story',
        'trip_blog',
        'trip_forum',
        'trip_forum_other',
        'trip_forum_expat',
        'trip_forum_buysell',
        'trip_forum_travelmate',
        'trip_image',
        'trip_offer'
    ];

    protected $forumTypes = [
        'trip_forum',
        'trip_forum_other'
    ];

}
