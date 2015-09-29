<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Content;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    
        $photo = Content::whereType('photo')
                ->orderByRaw('RAND()')
                ->take(3)
                ->get();

        view()->share('random_image', isset($photo[0]) ? $photo[0]->imagePreset('large') : null);
        view()->share('random_image2', isset($photo[1]) ? $photo[1]->imagePreset('large') : null);
        view()->share('random_image3', isset($photo[2]) ? $photo[2]->imagePreset('large') : null);
    
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
