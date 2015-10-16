<?php

namespace App\Hashers;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class Md5Hasher implements HasherContract
{
    public function make($value, array $options = [])
    {
        return md5($value);
    }

    public function check($value, $hashedValue, array $options = [])
    {
        return $this->make($value) === $hashedValue;
    }

    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }
}
