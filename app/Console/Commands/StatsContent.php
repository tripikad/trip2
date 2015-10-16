<?php

namespace App\Console\Commands;

use DB;
use Carbon\Carbon;

class StatsContent extends StatsBase
{
    protected $signature = 'stats:content {--years=3}';

    public function handle()
    {
        $newest = DB::connection($this->connection)
            ->table('node')
            ->max('created');

        $this->line(implode(',', array_merge(['Date'], $this->contentTypes)));

        for ($i = 1; $i < $this->option('years') * 12; $i++) {
            $from = Carbon::now()->subMonths($i)->startOfMonth();
            $to = Carbon::now()->subMonths($i)->endOfMonth();

            $values = [$to->format('F Y')];

            foreach ($this->contentTypes as $type) {
                $values[] = \DB::connection($this->connection)
                    ->table('node')
                    ->whereBetween('created', [$from->getTimestamp(), $to->getTimestamp()])
                    ->whereType($type)
                    ->count();
            }

            $this->line(implode(',', $values));
        }
    }
}
