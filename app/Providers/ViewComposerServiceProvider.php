<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DOMDocument;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeSvgStandalone();
    }

    /**
     * Compose the SVG standalone.
     */
    private function composeSvgStandalone()
    {
        view()->composer('component.svg.standalone', function ($view) {

            $data = $view->getData();
            if (! file_exists(public_path('/svg/'.$data['name'].'.svg'))) {
                $logo = '';
            } else {
                $svg = new DOMDocument();

                $svg->load(public_path('/svg/'.$data['name'].'.svg'));

                $logo = $svg->saveXML($svg->documentElement);
            }

            $view->with('name', $logo);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
