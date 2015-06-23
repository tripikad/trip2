<?php namespace App\Console\Commands;

use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StatsUsersOld extends StatsBase
{

    protected $signature = 'stats:usersold';

    public function handle()
    {

        $this->line('Id,Created,Created,Diff');

        $results = DB::connection($this->connection)
            ->table('users')
            ->select('uid', 'created')
            ->orderBy('uid')
            ->where('uid', '>', 0)
            ->take(200)
            ->get();
        
        $prev = 0;

        foreach($results as $result) {

            $diff = $result->created - $prev;

            $this->line(join(',', [
                $result->uid,
                $result->created,
                Carbon::createFromTimestamp($result->created)->format('d M Y'),
                $diff,
            ]));
            
            $prev = $result->created;
   
        }
        
    }

}
