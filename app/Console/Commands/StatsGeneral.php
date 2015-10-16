<?php

namespace App\Console\Commands;

use DB;
use Carbon\Carbon;

class StatsGeneral extends StatsBase
{
    protected $signature = 'stats:general {--years=15}';

    public function handle()
    {
        $newest = DB::connection($this->connection)
            ->table('node')
            ->max('created');

        $this->line('Date,Contents,Comments,Anonym.Comments,Users');

        for ($i = 1; $i < $this->option('years') * 12; $i++) {
            $from = Carbon::createFromTimestamp($newest)->subMonths($i)->startOfMonth();
            $to = Carbon::createFromTimestamp($newest)->subMonths($i)->endOfMonth();

            $content = \DB::connection($this->connection)
                ->table('node')
                ->whereBetween('created', [$from->getTimestamp(), $to->getTimestamp()])
                ->whereIn('type', $this->contentTypes)
                ->count();

            $comments = \DB::connection($this->connection)
                ->table('comments')
                ->join('node', 'comments.nid', '=', 'node.nid')
                ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
                ->where('comments.uid', '>', 0)
                ->whereIn('node.type', $this->contentTypes)
                ->count();

            $comments_anonymous = \DB::connection($this->connection)
                ->table('comments')
                ->join('node', 'comments.nid', '=', 'node.nid')
                ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
                ->where('comments.uid', '=', 0)
                ->whereIn('node.type', $this->contentTypes)
                ->count();

            $users = \DB::connection($this->connection)
                ->table('users')
                ->whereBetween('created', [$from->getTimestamp(), $to->getTimestamp()])
                ->count();

            $this->line(implode(',', [
                $to->format('F Y'),
                $content,
                $comments,
                $comments_anonymous,
                $users,
            ]));
        }
    }
}
