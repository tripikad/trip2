<?php

namespace App\Providers;

use PHPUnit\Framework\Assert as PHPUnit;

use Laravel\Dusk\Browser;
use Illuminate\Support\ServiceProvider;

class DuskServiceProvider extends ServiceProvider
{
    /**
     * Register the Dusk's browser macros.
     *
     * @return void
     */
    public function boot()
    {
        Browser::macro('scrollToId', function ($id = null) {
            $this->script("document.getElementById('$id').scrollIntoView();");

            return $this;
        });

        Browser::macro('scrollToBottom', function ($title = null) {
            $this->script('window.scrollTo(0, 9999999)');
            return $this;
        });
    }
}
