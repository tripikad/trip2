<?php

namespace App\Console\Commands;

use DB;

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

        foreach ($users as $user) {
            $profile = DB::connection($this->connection)
                ->table('profile_values')
                ->where('uid', '=', $user->uid)
                ->pluck('value', 'fid');

            $this->line(implode(',', [
                $user->name,
                isset($profile[13]) ? $profile[13] : null, // Homepage
                isset($profile[18]) ? $profile[18] : null, // Showterms
                isset($profile[19]) ? $profile[19] : null, // Hideterms
                isset($profile[20]) ? $profile[20] : null, // Hidecontent
                isset($profile[21]) ? $profile[21] : null, // E-mail
                isset($profile[22]) ? $profile[22] : null, // Phone
                isset($profile[23]) ? $profile[23] : null, // Address
                isset($profile[24]) ? $profile[24] : null, // Gender
                isset($profile[25]) ? $profile[25] : null, // Birth
                isset($profile[26]) ? $profile[26] : null, // Location
            ]));
        }
    }
}
