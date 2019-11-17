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
                            $destination
                                ->vars()
                                ->usersWantsToGo()
                                ->count()
                        )
                )
                ->push(
                    component('StatCard')
                        ->with('icon', 'icon-star')
                        ->with(
                            'title',
                            $destination
                                ->vars()
                                ->usersHaveBeen()
                                ->count()
                        )
                )
        );
    }
}
