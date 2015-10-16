<?php

namespace App\Console\Commands;

use DB;
use Carbon\Carbon;

class StatsUsersOld extends StatsBase
{
    protected $signature = 'stats:users:old';

    public function getOldestComment($uid)
    {
        return DB::connection($this->connection)
            ->table('comments')
            ->where('uid', '=', $uid)
            ->min('timestamp');
    }

    public function getOldestContent($uid)
    {
        return DB::connection($this->connection)
            ->table('node')
            ->where('uid', '=', $uid)
            ->where('type', '!=', 'weblink')
            ->min('created');
    }

    public function calculateMin($first, $second)
    {
        if ($first < 1) {
            return $second;
        }
        if ($second < 1) {
            return $first;
        }

        return min($first, $second);
    }

    public function formatDate($timestamp)
    {
        return ($timestamp > 0) ? Carbon::createFromTimestamp($timestamp)->format('d M Y') : '';
    }

    public function handle()
    {
        $this->line('Id,Created,Content,Comment,Created,Diff,Content,Comment,Oldest');

        $results = DB::connection($this->connection)
            ->table('users')
            ->select('uid', 'created')
            ->orderBy('uid')
            ->where('uid', '>', 0)
            ->take(20)
            ->get();

        $prev = 0;

        foreach ($results as $result) {
            $diff = $result->created - $prev;

            $this->line(implode(',', [
                $result->uid,
                $result->created,
                $this->getOldestContent($result->uid),
                $this->getOldestComment($result->uid),
                $this->formatDate($result->created),
                $diff,
                $this->formatDate($this->getOldestContent($result->uid)),
                $this->formatDate($this->getOldestComment($result->uid)),
                $this->formatDate(
                    $this->calculateMin(
                        $this->getOldestContent($result->uid),
                        $this->getOldestComment($result->uid)
                    )
                ),
            ]));

            $prev = $result->created;
        }
    }
}
