<?php

namespace App\Console\Commands;

use DB;

class StatsContentCount extends StatsBase
{
    protected $signature = 'stats:content:count';

    public function contentTypes()
    {
        return DB::connection($this->connection)
            ->table('node')
            ->select('type')
            ->groupBy('type')
            ->pluck('type');
    }

    public function contentCount()
    {
        $this->line('Type,Total,Published,Unpublished');

        foreach ($this->contentTypes() as $type) {
            $results = DB::connection($this->connection)
                ->table('node')
                ->whereType($type);

            $total = $results->count();
            $published = $results->whereStatus(1)->count();

            $this->line(implode(',', [
                $type,
                $total,
                $published,
                $total - $published,
            ]));
        }
    }

    public function handle()
    {
        $this->contentCount();
    }
}
