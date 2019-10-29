<?php

namespace App\Http\Controllers;

class ExperimentsController extends Controller
{
    public function store()
    {
        dd(request()->all());
    }

    public function index()
    {
        return layout('Two')
            ->with('title', 'Experiments')
            ->with(
                'content',
                collect()
                    ->push(
                        component('FormSliderMultiple')
                            ->with('min-Range', 10)
                            ->with('suffix', '€')
                    )
                    ->push(
                        component('Form')
                            ->with('route', route('experiments.store'))
                            ->with(
                                'fields',
                                collect()
                                    ->push(
                                        component('FormSliderMultiple')
                                            ->with('name', 'one')
                                            ->with('name2', 'two')
                                    )
                                    ->push(component('FormButton'))
                            )
                    )
            )
            ->render();
    }
}
