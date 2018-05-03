<?php

namespace App\Hashers;

use RuntimeException;
use Illuminate\Hashing\HashManager;

class Md5Hasher extends HashManager
{
    public function make($value, array $options = [])
    {

        return $this->driver()->make(md5($value), $options);

    }

    public function check($value, $hashedValue, array $options = [])
    {
        
        return $this->driver()->check(md5($value), $hashedValue, $options);
    
    }
}
