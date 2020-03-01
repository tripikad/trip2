<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;

class ExperimentsController extends Controller
{
    public function index()
    {
        $data = collect()->push(
            collect()
                ->put('a', 'ahaa')
                ->put('b', 'bebee')
        );

        return layout('Full')
            ->withItems(
                collect()->push(
                    component('Section')
                        ->withBackground('blue')
                        ->withItems(
                            component('Table')
                                ->is('white')
                                ->withItems($data)
                        )
                )
            )
            ->render();
    }
}
