<?php

namespace App\Http\Regions;

class TravelmateBottom
{
    public function render($travelmates)
    {
        return component('Block')
            ->is('uppercase')
            ->is('white')
            ->with('title', trans('frontpage.index.travelmate.title'))
            ->with('content', collect()
                ->push(component('Grid3')
                    ->with('gutter', true)
                    ->with('items', $travelmates->map(function ($travelmate) {
                        return region('TravelmateCard', $travelmate);
                    }))
                )
            );
    }
}
