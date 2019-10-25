<?php

namespace App\Http\Controllers;

class ExperimentsController extends Controller
{
    public function index()
    {
        return layout('Two')
            ->with(
                'content',
                collect()->push(
                    component('Title')
                        ->is('large')
                        ->with('title', 'Components')
                )
            )
            ->render();
    }
}
