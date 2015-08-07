<?php

namespace App\Console\Commands;

use DB;
use App\User;

class ConvertUsersOld extends ConvertBase
{

    protected $signature = 'convert:users:old';

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
            ->min('created');
    }

    public function calculateMin($first, $second) 
    {
        if ($first < 1) return $second;
        if ($second < 1) return $first;
        return min($first, $second);
    }

    public function convertUsersOld()
    {      
        $take = 60;
        $oldestUser = 903018060; // 13. aug 1998

        $userToFix = [1, 3, 5, 8, 10, 12, 15, 16, 20];

        $users = DB::connection($this->connection)
            ->table('users')
            ->take($take)
            ->orderBy('uid')
            ->get();

        $this->info('Converting old users');

        $this->output->progressStart($take);

        foreach ($users as $u) {
            
            if (! User::find($u->uid) && $u->uid > 0) {

                $oldestContribution = $this->calculateMin(
                    $this->getOldestContent($u->uid), 
                    $this->getOldestComment($u->uid)
                );

                $user = $this->getUser($u->uid);

                $user->created = (in_array($user->uid, $userToFix)) ? $oldestUser : $oldestContribution;

                $this->createUser($user);
                
            }

            $this->output->progressAdvance();

        }

        $this->output->progressFinish();

    }

    public function handle()
    {
        
        $this->convertUsersOld();

    }

}

