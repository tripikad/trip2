<?php

namespace App;

use App\User;

class UserVars
{
    
    protected $user;
   
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return call_user_func([$this, $property]);
        }
    }

    public function name()
    {
        return str_limit($this->user->name, 30);
    }

    public function rank()
    {
        return $this->user->rank * 90;
    }

}
