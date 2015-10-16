<?php

namespace App\Console\Commands;

use DB;
use Carbon\Carbon;

class StatsUsersNew extends StatsBase
{
    protected $signature = 'stats:usersnew {--years=10}';

    public function handle()
    {
        $newest = DB::connection($this->connection)
            ->table('users')
            ->max('created');

        $this->line('Date,Posts by new users,Comments by new users,Logged in new users,Total new users');

        for ($i = 1; $i < $this->option('years') * 12; $i++) {
            $from = Carbon::createFromTimestamp($newest)->subMonths($i)->startOfMonth();
            $to = Carbon::createFromTimestamp($newest)->subMonths($i)->endOfMonth();

            $posted = \DB::connection($this->connection)
            ->table('users')
            ->whereBetween('users.created', [$from->getTimestamp(), $to->getTimestamp()])
            ->where('users.login', '>', 0)
            ->join('node', 'users.uid', '=', 'node.uid')
            ->whereBetween('node.created', [$from->getTimestamp(), $to->getTimestamp()])
            ->whereIn('node.type', $this->contentTypes)
            ->count();

            $commented = \DB::connection($this->connection)
            ->table('users')
            ->whereBetween('users.created', [$from->getTimestamp(), $to->getTimestamp()])
            ->where('users.login', '>', 0)
            ->join('comments', 'users.uid', '=', 'comments.uid')
            ->join('node', 'comments.nid', '=', 'node.nid')
            ->whereBetween('comments.timestamp', [$from->getTimestamp(), $to->getTimestamp()])
            ->whereIn('node.type', $this->contentTypes)
            ->count();

            $logged = \DB::connection($this->connection)
            ->table('users')
            ->whereBetween('users.created', [$from->getTimestamp(), $to->getTimestamp()])
            ->where('login', '>', 0)
            ->count();

            $nonlogged = \DB::connection($this->connection)
            ->table('users')
            ->whereBetween('users.created', [$from->getTimestamp(), $to->getTimestamp()])
            ->where('login', '=', 0)
            ->count();

            $this->line(implode(',', [
            $to->format('F Y'),
            $posted,
            $commented,
            $logged,
            $logged + $nonlogged,
        ]));
        }
    }
}
