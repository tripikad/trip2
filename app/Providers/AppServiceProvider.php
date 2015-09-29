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
                ->first();

        view()->share(
            'random_image',
            $photo ? $photo->imagePreset('large') : null
        );
    
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
