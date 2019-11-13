<?php

namespace App\Http\Controllers;

class ExperimentsController extends Controller
{
    public function index()
    {
        return layout('One')
            ->with('title', 'Experiments')
            ->with('color', 'blue')
            ->with(
                'header',
                collect()
                    ->push(
                        component('Dotmap')
                            ->with('city', 551)
                            ->with('country', 332)
                            ->with('countries', config('dots'))
                            ->with('cities', config('cities'))
                    )

                    ->render()
                    ->implode('')
            )
            ->render();
    }
}
