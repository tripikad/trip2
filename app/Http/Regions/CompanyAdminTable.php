<?php

namespace App\Http\Regions;

use DB;
use Illuminate\Support\Collection;
use App\Offer;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class CompanyAdminTable
{
  private function getMonthlyStat($user_id)
  {
    return Collection::times(3, function ($item, $month) use ($user_id) {
      $table = (new Offer())->getTable();

      return Offer::select(
        DB::raw("DATE_FORMAT(created_at, '%M') date"),
        DB::raw('count(' . $table . '.id) as aggregate')
      )
        ->groupBy(DB::raw('MONTH(' . $table . '.created_at)'))
        ->where('user_id', $user_id)
        ->whereBetween('created_at', [
          $month == 0
            ? Carbon::now()->startOfMonth()
            : Carbon::now()
              ->subMonths($month)
              ->startOfMonth(),
          $month == 0
            ? Carbon::now()->endOfMonth()
            : Carbon::now()
              ->subMonths($month)
              ->endOfMonth()
        ])
        ->orderBy('created_at')
        ->pluck('aggregate');
    })
      ->map(function ($counts, $month) {
        return [
          $month == 0
            ? Date::now()->format('M Y')
            : Date::now()
              ->subMonths($month)
              ->format('M Y'),
          $counts->count() ? $counts[0] : 0
        ];
      })
      ->fromPairs();
  }

  public function render($companies)
  {
    dd($this->getMonthlyStat(12));

    return component('Table')
      ->is('white')
      ->withItems(
        $companies->map(function ($company) {
          return collect()
            ->put('Name', $company->name)
            ->put(
              'Action',
              component('Button')
                ->is('orange')
                ->is('small')
                ->is('narrow')
                ->with('title', trans('company.index.edit'))
                ->with('route', route('company.edit', [$company, 'redirect' => 'company.admin.index']))
            );
        })
      );
  }
}
