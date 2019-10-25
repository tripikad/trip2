<?php

namespace App\Http\Controllers;

class ExperimentsController extends Controller
{
    public function index()
    {
        return layout('Two')
            ->with(
                'content',
                collect()->push(component('Button')->with('title', 'Button'))
            )
            ->render();
    }
}
