<?php

namespace App\Console\Commands;

use DB;
use Carbon\Carbon;

class StatsFlagDetails extends StatsBase
{
    protected $signature = 'stats:flagdetails {--years=3}';

    public function handle()
    {
        $newest = DB::connection($this->connection)
            ->table('flag_content')
            ->max('timestamp');

        $this->line('Date,Content +,Content -,Comment +,Comment -');

        for ($i = 1; $i < $this->option('years') * 12; $i++) {
            $from = Carbon::createFromTimestamp($newest)->subMonths($i)->startOfMonth();
            $to = Carbon::createFromTimestamp($newest)->subMonths($i)->endOfMonth();

            $contents_plus = \DB::connection($this->connection)
            ->table('flag_content')
            ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
            ->where('content_type', '=', 'node')
             ->where('fid', '=', '2')
            ->count();

            $contents_minus = \DB::connection($this->connection)
            ->table('flag_content')
            ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
            ->where('content_type', '=', 'node')
            ->where('fid', '=', '3')
            ->count();

            $comments_plus = \DB::connection($this->connection)
            ->table('flag_content')
            ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
            ->where('content_type', '=', 'comment')
            ->where('fid', '=', '4')
            ->count();

            $comments_minus = \DB::connection($this->connection)
            ->table('flag_content')
            ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
            ->where('content_type', '=', 'comment')
            ->where('fid', '=', '5')
            ->count();

            $this->line(implode(',', [
            $to->format('F Y'),
            $contents_plus,
            $contents_minus,
            $comments_plus,
            $comments_minus,
        ]));
        }
    }
}
