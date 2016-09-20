<?php

namespace App\Http\Regions;

class FrontpageAbout
{
    public function render()
    {
        return component('GridSplit')
            ->with('left_content', collect()
                ->push(component('Block')
                    ->is('dark')
                    ->is('white')
                    ->with('title', 'Trip.ee on reisihuviliste kogukond, keda ühendab reisipisik ning huvi kaugete maade ja kultuuride vastu.')
                    ->with('content', collect()
                        ->push(component('Link')
                            ->with('title', trans('content.action.more.about'))
                            ->with('route', route('v2.static.show', [1534]))
                        )
                    )
                )
            )
            ->with('right_content', collect()
                ->push(component('Button')
                    ->with('title', trans('frontpage.index.about.register'))
                    ->with('route', route('register.form'))
                )
            );
    }
}
