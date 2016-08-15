<?php

namespace App;

class V2UserVars
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

        $message = '%s does not respond to the "%s" property or method.';
        
        throw new Exception(
            sprintf($message, static::class, $property)
        );
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
