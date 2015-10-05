<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Content;
use App\Destination;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    
        $photos = Content::whereType('photo')
                ->orderByRaw('RAND()')
                ->take(3)
                ->get();

        view()->share('random_image', isset($photos[0]) ? $photos[0]->imagePreset('large') : null);
        view()->share('random_image2', isset($photos[1]) ? $photos[1]->imagePreset('large') : null);
        view()->share('random_image3', isset($photos[2]) ? $photos[2]->imagePreset('large') : null);

        $destinations = Destination::orderByRaw('RAND()')
                ->take(3)
                ->get();

        view()->share('random_destination', isset($destinations[0]) ? $destinations[0]->name : null);
        view()->share('random_destination2', isset($destinations[1]) ? $destinations[1]->name : null);
        view()->share('random_destination3', isset($destinations[2]) ? $destinations[2]->name : null);

    
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
