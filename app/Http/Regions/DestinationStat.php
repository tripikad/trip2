<?php

namespace App\Http\Regions;

class DestinationStat
{
  public function render($destination)
  {
    return component('Flex')->with(
      'items',
      collect()
        ->push(
          component('StatCard')
            ->with('icon', 'icon-pin')
            ->with(
              'title',
              trans('destination.show.stat.havebeen', [
                'count' => $destination
                  ->vars()
                  ->usersHaveBeen()
                  ->count()
              ])
            )
        )
        ->push(
          component('StatCard')
            ->with('icon', 'icon-star')
            ->with(
              'title',
              trans('destination.show.stat.wantstogo', [
                'count' => $destination
                  ->vars()
                  ->usersWantsToGo()
                  ->count()
              ])
            )
        )
    );
  }
}
