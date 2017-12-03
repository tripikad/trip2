<?php

namespace App\Http\Controllers;

class V2ExperimentsLayoutController extends Controller
{
    public function indexTwo()
    {
        return layout('Two')

            ->with('header', component('Placeholder')
                    ->with('title', 'header')
            )

            ->with('top', collect()
                ->push(component('Placeholder')
                    ->with('title', 'Top')
                )
            )

            ->with('content', collect()
                ->push(component('Placeholder')
                    ->with('title', 'Content1')
                )
                ->push(component('Placeholder')
                    ->with('title', 'Content2')
                )
            )

            ->with('sidebar', collect()
                ->push(component('Placeholder')
                    ->with('title', 'Sidebar1')
                )
                ->push(component('Placeholder')
                    ->is('ad')
                    ->with('title', 'SIDEBAR_SMALL ad')
                )
                ->push(component('Placeholder')
                    ->with('title', 'Sidebar2')
                )
            )

            ->with('bottom', collect()
                ->push(component('Placeholder')
                    ->with('title', 'Bottom')
                )
            )

            ->with('footer', component('Placeholder')
                ->with('title', 'Footer')
            )

            ->render();
    }
}
