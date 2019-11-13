<?php

namespace App\Http\Controllers;

use App\Content;

class ExperimentsController extends Controller
{
    public function index()
    {
        $photos = Content::getLatestPagedItems('photo', 9, 411);

        return layout('One')
            ->with('title', 'Experiments')
            ->with('color', 'blue')
            ->with(
                'header',
                collect()
                    ->push(region('PhotoRow', $photos))
                    ->br(2)
                    ->push(
                        component('Flex')
                            ->with('justify', 'center')
                            ->with('direction', 'column')
                            ->with(
                                'items',
                                collect()
                                    ->push(
                                        component('Dotmap')
                                            ->with('city', 4654)
                                            ->with('country', 411)
                                            ->with('countries', config('dots'))
                                            ->with('cities', config('cities'))
                                    )
                                    ->br()
                                    ->push(
                                        component('Title')
                                            ->is('white')
                                            ->with(
                                                'title',
                                                'Matkareis Birmas 2090€'
                                            )
                                    )
                                    ->br()
                                    ->push(
                                        component('Button')
                                            ->is('orange')
                                            ->with('title', 'Broneeri reis')
                                    )
                            )
                    )
                    ->render()
                    ->implode('')
            )
            ->render();
    }
}
