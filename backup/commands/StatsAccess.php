<?php

namespace App\Console\Commands;

use DB;
use Carbon\Carbon;

class StatsAccess extends StatsBase
{
    protected $signature = 'stats:access';

    public function handle()
    {
        $newest = DB::connection($this->connection)
            ->table('accesslog')
            ->max('timestamp');

        $this->line('Date,Access,AccessLogged,Session,SessionLogged');

        for ($i = 1; $i < 24 * 10; $i++) {
            $from = Carbon::createFromTimestamp($newest)->subHours($i)->minute(0);
            $to = Carbon::createFromTimestamp($newest)->subHours($i - 1)->minute(0);

            $access = \DB::connection($this->connection)
              ->table('accesslog')
              ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
              ->where('uid', '=', 0)
              ->count();

            $access_logged = \DB::connection($this->connection)
              ->table('accesslog')
              ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
              ->where('uid', '>', 0)
              ->count();

            $session = \DB::connection($this->connection)
              ->table('sessions')
              ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
              ->where('uid', '=', 0)
              ->count();

            $session_logged = \DB::connection($this->connection)
              ->table('sessions')
              ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
              ->where('uid', '>', 0)
              ->count();

            $this->line(implode(',', [
              $from->format('d.F.Y | H:i').'-'.$to->format('H:i'),
              $access,
              $access_logged,
              $session,
              $session_logged,
          ]));
        }
    }
}
