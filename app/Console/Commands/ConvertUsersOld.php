<?php

namespace App\Console\Commands;

class ConvertUsersOld extends ConvertBase
{

    protected $signature = 'convert:users:old';


    public function convertUsersOld()
    {      
        $take = 100;

        $users = \DB::connection($this->connection)
            ->table('users')
            ->take($take)
            ->orderBy('uid')
            ->get();

        $this->output->progressStart($take);

        foreach ($users as $user) {

            $this->convertUser($user->uid);

            $this->output->progressAdvance();

        }

        $this->output->progressFinish();

    }

    public function handle()
    {
        
        $this->convertUsersOld();

    }

}

