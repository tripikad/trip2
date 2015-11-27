<?php

namespace App\Console\Commands;

use DB;

class StatsPages extends StatsBase
{
    protected $signature = 'stats:pages';

    public function dump($type)
    {
        $statusMap = [
            0 => 'unpublished',
            1 => 'published',
        ];

        $pages = DB::connection($this->connection)
            ->table('node')
            ->join('node_revisions', 'node_revisions.nid', '=', 'node.nid')
            ->oldest('created')
            ->whereType($type);

        foreach ($pages->get() as $page) {
            $this->line('***');
            $this->line('# '.mb_convert_case($page->title.(! $page->status ? ', unpublished' : ''), MB_CASE_UPPER));
            $this->line('http://trip.ee/node/'.$page->nid);
            $this->line('');
            $this->line($page->body);
        }
    }

    public function countContent()
    {
        $types = [
            'page',
            'trip_hotel',
            'poll',
            'trip_guide',
            'task',
            'trip_question',
            'book',
            'trip_reisikaaslasekuulutus',
            'trip_forum_commercial',
            'quiz',
            'quiz_directions',
            'long_answer',
            'matching',
            'multichoice',
            'truefalse',
            'short_answer',
            'scale',
        ];

        foreach ($types as $type) {
            $results = DB::connection($this->connection)
                ->table('node')
                ->whereType($type);

            $this->line(implode(',', [
                $type,
                $results->count(),
                $results->whereStatus(0)->count(),
            ]));
        }
    }

    public function handle()
    {
        $this->dump('trip_guide');
    //    $this->countContent();
    }
}
