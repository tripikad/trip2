<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class V2StatisticsController extends Controller
{
    public function index()
    {
        return layout('1col')

            ->with('background', component('BackgroundMap'))

            ->with('color', 'gray')

            ->with('header', region('StaticHeader', collect()
                ->push(component('Title')->with(
                    'title',
                    trans('statistics.index.title')
                ))
            ))

            ->with('content', collect()
                ->merge(collect(['User', 'Content', 'Comment', 'Flag'])
                    ->flatMap(function ($model) {
                        return collect()
                            ->push(component('Title')
                                ->with('title', $model)
                            )
                            ->push(component('Title')
                                ->is('small')
                                ->with('title', trans('statistics.index.monthly'))
                            )
                            ->push(component('Linechart')
                                ->with('items', $this->getMonthlyStat($model))
                            )
                            ->push(component('Title')
                                ->is('small')
                                ->with('title', trans('statistics.index.weekly'))
                            )
                            ->push(component('Linechart')
                                ->with('items', $this->getWeeklyStat($model))
                            );
                    })
                )
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function getMonthlyStat($model)
    {
        return Collection::times(3, function ($year) use ($model) {
            $model = 'App\\'.$model;
            $table = (new $model)->getTable();

            return $model::select(
                    DB::raw("DATE_FORMAT(created_at, '%M') date"),
                    DB::raw('count('.$table.'.id) as aggregate')
                )
                ->groupBy(DB::raw('MONTH('.$table.'.created_at)'))
                ->whereBetween(
                    'created_at',
                    // ::times gives us values from 1 to 3
                    // We subtract 1 so we get:
                    // 0 for current year
                    // 1 for previous year
                    // ..etc
                    $year - 1 == 0 ? [
                        Carbon::now()->startOfYear(), 
                        Carbon::now()->startOfMonth(), // = End of last month
                    ] : [
                        Carbon::now()->subYears($year - 1)->startOfYear(),
                        Carbon::now()->subYears($year - 1)->endOfYear(),
                    ]
                )
                ->orderBy('created_at')
                ->pluck('aggregate');
        })
        ->map(function ($values, $year) {
            return collect()
                // We fill the values that are missing
                // between now and end of current year
                // with 0s so the graph can skip those
                // months
                // TODO: Replace with ->pad() in Laravel 5.5
                ->put('values', array_pad($values->all(), 12, 0))
                ->put('title', Carbon::now()
                    // map() starts with 0 so we instantly get
                    // 0 - this year
                    // 1 - previous year
                    // ...etc
                    ->subYears($year)
                    ->format('Y')
                );
        });
    }

    public function getWeeklyStat($model)
    {
        return Collection::times(3, function ($year) use ($model) {
            
            $model = 'App\\'.$model;
            $table = (new $model)->getTable();

            return $model::select(
                    DB::raw("DATE_FORMAT(created_at, '%u') date"),
                    DB::raw('count('.$table.'.id) as aggregate')
                )
                ->groupBy(DB::raw('WEEK('.$table.'.created_at)'))
                ->whereBetween(
                    'created_at',
                    $year - 1 == 0 ? [
                        Carbon::now()->startOfYear(),
                        // We subtract one week so we will be
                        // not get caught on issues with 
                        // weeks starting with Sunday
                        Carbon::now()->subWeek(1)->endOfWeek()
                    ] : [
                        Carbon::now()->subYears($year - 1)->startOfYear(),
                        Carbon::now()->subYears($year - 1)->endOfYear(),
                    ]
                )
                ->orderBy('created_at')
                ->pluck('aggregate');
        })
        ->map(function ($values, $year) {
            return collect()
                ->put('values', array_pad($values->all(), 54, 0))
                ->put('title', Carbon::now()
                    ->subYears($year)
                    ->format('Y')
                );
        });
    }
}
