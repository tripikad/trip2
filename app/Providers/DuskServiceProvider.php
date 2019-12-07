<?php

namespace App\Providers;

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
  }
}
