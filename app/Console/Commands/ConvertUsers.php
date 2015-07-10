<?php

namespace App\Console\Commands;

class ConvertUsers extends ConvertBase
{

    protected $signature = 'convert:users';


    public function convertUsers()
    {      
        $users = \DB::connection($this->connection)
            ->table('users')
            ->join('users_roles', 'users_roles.uid', '=', 'users.uid')
            ->join('role', 'role.rid', '=', 'users_roles.rid')
   //         ->latest('created')
            ->take(100)
            ->get();

        foreach ($users as $user) {

            $this->convertUser($user->uid);

        }

    }

    public function handle()
    {
        
        $this->convertUsers();

    }

}

