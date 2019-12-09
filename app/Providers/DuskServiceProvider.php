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
        Browser::macro('scrollToBottom', function ($title = null) {
            $this->script('window.scrollTo(0, 9999999)');
            return $this;
        });

        Browser::macro('see', function ($text = '') {
            PHPUnit::assertTrue(!!strstr($this->driver->getPageSource(), $text), "Do not see [$text] in page source");
            return $this;
        });

        Browser::macro('dontSee', function ($text = '') {
            PHPUnit::assertTrue(!strstr($this->driver->getPageSource(), $text), "Seeing [$text] in page source");
            return $this;
        });
    }
}
