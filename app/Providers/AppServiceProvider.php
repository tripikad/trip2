<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Analytics;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Guard $auth)
    {
        $this->google_analytics_track($auth);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    protected function google_analytics_track($auth)
    {
        view()->composer('layouts.main', function($view) use ($auth) {
            $currentUser = $auth->user();

            if ($auth->check()) {
                Analytics::setUserId($auth->user()->id);
                Analytics::trackCustom("ga('set', 'user_role', '".$auth->user()->role."');");
            }
        });
    }
}
