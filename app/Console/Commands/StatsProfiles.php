<?php namespace App\Console\Commands;

use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StatsProfiles extends StatsBase
{

    protected $signature = 'stats:profiles';

    public function handle()
    {

        $this->line('User,Homepage,Showterms,Hideterms,Hidecontent,E-mail,Phone,Address,Gender,Birth,Location');

        $users = DB::connection($this->connection)
            ->table('users')
            ->where('users.uid', '>', 0)
            ->take(1000)
            ->latest('created')
            ->get();
        
        foreach($users as $user) {

            $profile = DB::connection($this->connection)
                ->table('profile_values')
                ->where('uid', '=', $user->uid)
                ->lists('value', 'fid');
            
            $this->line(join(',', [
                $user->name,
                isset($profile[13]) ? $profile[13] : null,
                isset($profile[18]) ? $profile[18] : null,
                isset($profile[19]) ? $profile[19] : null,
                isset($profile[20]) ? $profile[20] : null,
                isset($profile[21]) ? $profile[21] : null,
                isset($profile[22]) ? $profile[22] : null,
                isset($profile[23]) ? $profile[23] : null,
                isset($profile[24]) ? $profile[24] : null,
                isset($profile[25]) ? $profile[25] : null,
                isset($profile[26]) ? $profile[26] : null,
            ]));

        }
        
    }

}
