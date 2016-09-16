<?php

namespace App\Http\Regions;

class TravelmateAbout
{
    public function render()
    {
        return component('Block')
                ->with('subtitle', trans('content.travelmate.description.title'))
                ->with('content', collect()
                    ->push(component('Body')
                        ->with('body', trans('content.travelmate.description.text'))
                    )
                );
    }
}
