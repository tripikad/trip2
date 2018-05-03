<?php

namespace App\Providers;

use App\Hashers\Md5Hasher;
use Illuminate\Hashing\HashServiceProvider;

class Md5HashServiceProvider extends HashServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton('hash', function ($app) {
            return new Md5Hasher($app);
        });

        $this->app->singleton('hash.driver', function ($app) {
            return $app['hash']->driver();
        });
    }

    public function provides()
    {
        return ['hash', 'hash.driver'];
    }
}
