<?php

namespace App\Hashers;

use RuntimeException;
use Illuminate\Hashing\BcryptHasher as HasherContract;

class Md5Hasher extends HasherContract
{
    public function make($value, array $options = [])
    {
        $cost = isset($options['rounds']) ? $options['rounds'] : $this->rounds;

        $hash = password_hash(md5($value), PASSWORD_BCRYPT, ['cost' => $cost]);

        if ($hash === false) {
            throw new RuntimeException('Bcrypt hashing not supported.');
        }

        return $hash;
    }

    public function check($value, $hashedValue, array $options = [])
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }

        return password_verify(md5($value), $hashedValue);
    }
}
