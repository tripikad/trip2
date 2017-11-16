<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
=======
use DB;
use App\User;
>>>>>>> origin/kika-charts-2
use App\Content;
use Carbon\Carbon;
use App\Destination;
use Illuminate\Support\Collection;

class V2ExperimentsController extends Controller
{
<<<<<<< HEAD
=======
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
>>>>>>> origin/kika-charts-2

    public function index()
    {
        $user = auth()->user();

        return layout('1col')

            ->with('content', collect()
<<<<<<< HEAD
 
=======

                ->push(component('Title')
                    ->with('title', 'Linecart')
                )

                ->merge(collect(['User', 'Content', 'Comment', 'Flag'])
                    ->flatMap(function ($model) {
                        return collect()
                            ->push(component('Title')
                                ->is('small')
                                ->with('title', $model)
                            )
                            ->push(component('Linechart')
                                ->with('items', $this->getMonthlyStat($model))
                            );
                    })
                )

>>>>>>> origin/kika-charts-2
                ->push(component('Title')
                    ->with('title', 'Barchart')
                )

                ->push(component('Barchart')
                    ->with('items', collect()
                        ->push(['title' => 'One', 'value' => 12])
                        ->push(['title' => 'Two', 'value' => 34])
                    )
                )

                ->push('&nbsp;')

                ->push(component('Title')
                    ->with('title', 'Small editor')
                )

                ->push(component('EditorSmall')
                    ->with('value', 'Testing it out')
                )

                ->push(component('Title')
                    ->with('title', 'Misc')
                )

                ->push(component('MetaLink')
                    ->with('title', 'Selects')
                    ->with('route', route('experiments.select.index'))
                )

                ->push(component('MetaLink')
                    ->with('title', 'Fonts')
                    ->with('route', route('experiments.fonts.index'))
                )

                ->push(component('MetaLink')
                    ->with('title', 'Map')
                    ->with('route', route('experiments.map.index'))
                )

            )

            ->render();
    }

    public function selectIndex()
    {
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();

        return layout('1col')

            ->with('content', collect()

                ->push(component('Form')
                    ->with('route', route('experiments.select.create'))
                    ->with('fields', collect()
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'destinations1')
                            ->with('options', $destinations)
                            ->with('value', [1])
                            ->with('placeholder', trans('content.edit.field.destinations.placeholder'))
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'destinations2')
                            ->with('options', $destinations)
                            ->with('value', [2, 3])
                            ->with('placeholder', trans('content.edit.field.destinations.placeholder'))
                        )
                        ->push(component('FormSelect')
                            ->with('name', 'destination1')
                            ->with('options', $destinations)
                            ->with('value', 4)
                            ->with('placeholder', trans('content.edit.field.destinations.placeholder'))
                        )
                        ->push(component('FormSelect')
                            ->with('name', 'destination2')
                            ->with('options', $destinations)
                            ->with('value', 5)
                            ->with('placeholder', trans('content.edit.field.destinations.placeholder'))
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('content.edit.submit.title'))
                        )
                    )
                )
            )

            ->render();
    }

    public function selectCreate()
    {
        dump(request()->all());
    }

    public function mapIndex()
    {
        return layout('1col')

            ->with('content', collect()
                ->push(component('Dotmap')
                    ->with('dots', config('dots'))
                )
            )

        ->render();
    }

    public function fontsIndex()
    {
        return layout('1col')

            ->with('content', collect()
                ->push(component('FontExperiment'))
            )

            ->render();
    }
}
