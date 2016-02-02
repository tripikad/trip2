<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Jenssegers\Date\Date;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->composeComponentDateSelect();
    }

    private function composeComponentDateSelect()
    {
        view()->composer('component.date.select', function ($view) {

            $data = $view->getData();

            if (isset($data['month'])) {
                $months = [];
                $year = Date::now()->format('Y');
                for ($i = 1; $i <= 12; ++$i) {
                    $months[$i] = Date::parse("01.$i.$year")->format('F');
                }

                $view->with('month', $months);
            } else {
                $numbers = [];

                for ($i = $data['from']; $i <= $data['to']; ++$i) {
                    $numbers[$i] = (strlen($i) == 1 ? '0' : '').
                        $i;
                }

                $view->with('from_to', $numbers);
            }

        });
    }

    public function register()
    {
        //
    }
}
