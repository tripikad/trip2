<?php namespace App\Console\Commands;

use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StatsMessages extends StatsBase
{

    protected $signature = 'stats:messages {--years=6}';

    public function handle()
    {

        $newest = DB::connection($this->connection)
            ->table('pm_message')
            ->max('timestamp');

        $this->line('Date,Messages');

        for ($i = 1; $i < $this->option('years') * 12; $i++) { 

            $from = Carbon::createFromTimestamp($newest)->subMonths($i)->startOfMonth();
            $to = Carbon::createFromTimestamp($newest)->subMonths($i)->endOfMonth();

            $msgs = \DB::connection($this->connection)
                ->table('pm_message')
                ->whereBetween('timestamp', [$from->getTimestamp(), $to->getTimestamp()])
                ->count();

            $this->line(join(',', [
                $to->format('F Y'),
                $msgs,
            ]));
   
        }
        
    }

}
