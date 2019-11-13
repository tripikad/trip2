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
                'top',
                collect()
                    ->push(
                        component('HeaderLight')
                            ->is('white')
                            ->with(
                                'navbar',
                                component('Navbar')
                                    ->with('search', component('NavbarSearch'))
                                    ->with(
                                        'logo',
                                        component('Icon')
                                            ->with('icon', 'tripee_logo')
                                            ->with('width', 200)
                                            ->with('height', 150)
                                    )
                                    ->with(
                                        'navbar_desktop',
                                        region('NavbarDesktop', 'white')
                                    )
                                    ->with(
                                        'navbar_mobile',
                                        region('NavbarMobile')
                                    )
                            )
                    )
                    ->push(
                        component('Flex')
                            ->with('justify', 'center')
                            ->with('direction', 'column')
                            ->with(
                                'items',
                                collect()
                                    ->push(
                                        component('Dotmap')
                                            ->with('startcity', 829)
                                            ->with('city', 4654)
                                            ->with('country', 411)
                                            ->with('countries', config('dots'))
                                            ->with('cities', config('cities'))
                                    )
                                    ->push(
                                        component('Flex')->with(
                                            'items',
                                            collect()->push(
                                                component('Tag')
                                                    ->is('white')
                                                    ->with(
                                                        'title',
                                                        'Seiklusreis'
                                                    )
                                            )
                                        )
                                    )
                                    ->br(2)
                                    ->push(
                                        component('Title')
                                            ->is('white')
                                            ->is('large')
                                            ->with(
                                                'title',
                                                'Matkareis Birmas 2090€'
                                            )
                                    )
                                    ->br()
                                    ->push(
                                        component('Flex')->with(
                                            'items',
                                            collect()
                                                ->push(
                                                    component('Title')
                                                        ->is('smaller')
                                                        ->is('white')
                                                        ->with(
                                                            'title',
                                                            '9 päeva'
                                                        )
                                                )
                                                ->push(
                                                    component('Title')
                                                        ->is('smaller')
                                                        ->is('white')
                                                        ->is('disabled')
                                                        ->with(
                                                            'title',
                                                            '21.02.2019 - 30.02.2019'
                                                        )
                                                )
                                        )
                                    )
                                    ->br()
                                    ->push(
                                        component('Flex')->with(
                                            'items',
                                            collect()->push(
                                                component('Title')
                                                    ->is('smallest')
                                                    ->is('white')
                                                    ->is('disabled')
                                                    ->with(
                                                        'title',
                                                        'Firma: Andmoments&nbsp;&nbsp;&nbsp;&nbsp;Giid: Wenna wend&nbsp;&nbsp;&nbsp;Grupp: 16 inimest'
                                                    )
                                            )
                                        )
                                    )
                                    ->br(2)
                                    ->push(
                                        component('Button')
                                            ->is('orange')
                                            ->with('title', 'Broneeri reis')
                                    )
                                    ->br(4)
                            )
                    )
                    ->push(region('PhotoRow', $photos))
            )
            ->with('footer', region('FooterLight', ''))
            ->render();
    }
}
