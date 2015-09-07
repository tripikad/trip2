<?php

namespace App\Hashers;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class Md5Hasher implements HasherContract {

    public function make($value, array $options = array()) {
        
        return md5($value);
    
    }

    public function check($value, $hashedValue, array $options = array()) {
        
        return $this->make($value) === $hashedValue;
    
    }

    public function needsRehash($hashedValue, array $options = array()) {
        
        return false;
    
    }

}