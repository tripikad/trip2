<?php

namespace App\Http\Controllers\Styleguide;

use App\Http\Controllers\Controller;

class StyleguideController extends Controller
{
    public function index()
    {
        return layout('Two')
            ->with(
                'content',
                collect()
                    ->push(region('StyleguideMenu'))
                    ->push(
                        component('Title')
                            ->is('large')
                            ->with('title', 'Styleguide')
                    )
            )

            ->render();
    }
}
