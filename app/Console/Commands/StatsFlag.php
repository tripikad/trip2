<?php

namespace App\Console\Commands;

use DB;
use Carbon\Carbon;

class StatsFlag extends StatsBase
{
    protected $signature = 'stats:flag {--years=10}';

    public function handle()
    {
        $newest = DB::connection($this->connection)
            ->table('flag_content')
            ->max('timestamp');

        $this->line('Date,Content flags,Comment flags,Destination flags');

        for ($i = 1; $i < $this->option('years') * 12; $i++) {
            $from = Carbon::createFromTimestamp($newest)->subMonths($i)->startOfMonth();
            $to = Carbon::createFromTimestamp($newest)->subMonths($i)->endOfMonth();

            $contents = \DB::connection($this->connection)
            ->table('flag_content')
            ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
            ->where('content_type', '=', 'node')
            ->whereIn('fid', [2, 3])
            ->count();

            $comments = \DB::connection($this->connection)
            ->table('flag_content')
            ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
            ->where('content_type', '=', 'comment')
            ->whereIn('fid', [4, 5])
            ->count();

            $terms = \DB::connection($this->connection)
            ->table('flag_content')
            ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
            ->where('content_type', '=', 'term')
            ->count();

            $this->line(implode(',', [
            $to->format('F Y'),
            $contents,
            $comments,
            $terms,
        ]));
        }
    }
}
