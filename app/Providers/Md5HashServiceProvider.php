<?php

namespace App\Providers;

use App\Hashers\Md5Hasher;
use Illuminate\Hashing\HashServiceProvider;

class Md5HashServiceProvider extends HashServiceProvider
{
    public function register()
    {
        $this->app->singleton('hash', function () {

            return new Md5Hasher;

        });
    }
}
