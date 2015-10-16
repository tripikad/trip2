<?php

namespace App\Console\Commands;

use DB;
use Carbon\Carbon;

class StatsTerms extends StatsBase
{
    protected $signature = 'stats:terms {--term=destination} {--years=3}';

    public function handle()
    {
        $terms = [
            'destination' => 'node.tid_1_1',
            'topic' => 'node.tid_2_1',
            'style' => 'node.tid_3_1',
        ];

        for ($i = 1; $i < $this->option('years') + 1; $i++) {
            $newest = DB::connection($this->connection)
                ->table('node')
                ->max('created');

            $from = Carbon::createFromTimestamp($newest)->subYears($i)->startOfYear();
            $to = Carbon::createFromTimestamp($newest)->subYears($i)->endOfYear();

            $this->line($from->year.', ');

            $term = $terms[$this->option('term')];

           // dd($term);

            $results = \DB::connection($this->connection)
                ->table('node')
                ->join('term_data', $term, '=', 'term_data.tid')
                ->select(['term_data.name', Db::raw('COUNT('.$term.') AS times')])
                ->groupBy($term)
                ->orderBy('times', 'desc')
                ->whereIn('node.type', $this->forumTypes)
                ->whereBetween('created', [$from->getTimestamp(), $to->getTimestamp()])
                ->take(20)
                ->get();

            foreach ($results as $result) {
                $this->line(implode(',', [
                    $result->name ? $result->name : 'Undefined',
                    $result->times,
                ]));
            }

            $total = \DB::connection($this->connection)
                ->table('node')
                ->whereIn('node.type', $this->forumTypes)
                ->whereBetween('created', [$from->getTimestamp(), $to->getTimestamp()])
                ->count();

            $this->line(implode(',', [
                'Total',
                $total,
            ]));
        }

        $this->line(',');
    }
}
