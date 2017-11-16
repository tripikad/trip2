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
                ->push(component('Title')->with('title', 'Statistics'))
            ))

            ->with('content', collect()
                ->merge(collect(['User', 'Content', 'Comment', 'Flag'])
                    ->flatMap(function ($model) {
                        return collect()
                            ->push(component('Title')
                                ->is('small')
                                ->with('title', $model)
                            )
                            ->push(component('Linechart')
                                ->with('items', $this->getMonthlyStat($model))
                            )
                            ->push(component('Linechart')
                                ->with('items', $this->getWeeklyStat($model))
                            );
                    })
                )
            )

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
                    $year - 1 == 0 ? [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->startOfMonth(),
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
                // Replace with ->pad in Laravel 5.5
                ->put('values', array_pad($values->all(), 12, 0))
                ->put('title', Carbon::now()
                    ->subYears($year)
                    ->format('Y')
                );
        });
    }

    public function getWeeklyStat($model)
    {
        return Collection::times(3, function($year) use ($model) {
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
                        Carbon::now()->subWeek(1)
                    ] : [
                        Carbon::now()->subYears($year - 1)->startOfYear(),
                        Carbon::now()->subYears($year - 1)->endOfYear()
                    ]
                )
                ->orderBy('created_at')
                ->pluck('aggregate');
        })
        ->map(function($values, $year) {
            return collect()
                // Replace with ->pad in Laravel 5.5
                ->put('values', array_pad($values->all(), 53, 0))
                ->put('title', Carbon::now()
                    ->subYears($year)
                    ->format('Y')
                ); 
        });
    }

}
