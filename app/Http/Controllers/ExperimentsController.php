<?php

namespace App\Http\Controllers;

class ExperimentsController extends Controller
{
    public function index()
    {
        return layout('Two')
            ->with('title', 'Experiments')
            ->with(
                'content',
                collect()->push(
                    component('FormSlider')
                        ->with('min-Range', 10)
                        ->with('suffix', '€')
                )
            )
            ->render();
    }
}
