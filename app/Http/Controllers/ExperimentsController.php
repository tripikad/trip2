<?php

namespace App\Http\Controllers;

use App\Content;

class ExperimentsController extends Controller
{
    protected function form()
    {
        return collect()->push(
            component('Form')->with(
                'fields',
                collect()
                    ->push(
                        component('FormTextfield')
                            ->is('white')
                            ->with('name', 'name')
                            ->with('title', 'Name')
                            ->with('value', '')
                    )
                    ->push(
                        component('FormTextfield')
                            ->with('name', 'email')
                            ->with('title', 'E-mail')
                            ->with('value', '')
                    )
                    ->push(
                        component('FormTextfield')
                            ->with('name', 'phone')
                            ->with('title', 'Phone')
                    )
                    ->push(
                        component('FormTextfield')
                            ->with('name', 'adults')
                            ->with('title', 'Number of adults')
                    )
                    ->push(
                        component('FormTextfield')
                            ->with('name', 'children')
                            ->with('title', 'Number of children')
                    )
                    ->push(
                        component('FormTextarea')
                            ->with('name', 'notes')
                            ->with('title', 'Notes')
                    )
                    ->push(
                        component('FormCheckbox')
                            ->with('name', 'insurance')
                            ->with('title', 'I need an insurance')
                    )
                    ->push(
                        component('FormCheckbox')
                            ->with('name', 'installments')
                            ->with('title', 'I want to pay by installments')
                    )
                    ->push(
                        component('FormCheckbox')
                            ->with('name', 'flexible')
                            ->with(
                                'title',
                                'I am flexible with dates (+-3 days)'
                            )
                    )
                    ->push(
                        component('FormButton')->with('title', 'Book an offer')
                    )
            )
        );
    }

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
                                    // ->push(
                                    //     component('Dotmap')
                                    //         ->with('startcity', 829)
                                    //         ->with('city', 4654)
                                    //         ->with('country', 411)
                                    //         ->with('dots', config('dots'))
                                    //         ->with('cities', config('cities'))
                                    // )
                                    ->push(
                                        component('Dotmap')
                                            ->with('dots', config('dots'))
                                            ->with('cities', config('cities'))
                                            ->with('activecountries', [
                                                411,
                                                357,
                                                311
                                            ])
                                            ->with('activecities', [4654, 566])
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
                    ->br()
                    ->push(
                        component('Title')
                            ->is('center')
                            ->is('white')
                            ->with('title', 'Broneeri reis')
                    )
            )
            ->with('content', $this->form())
            ->with('footer', region('FooterLight', ''))
            ->render();
    }
}
