<?php

namespace App\Http\Controllers;

use App\User;

class ExperimentsController extends Controller
{
    public function index()
    {
        $a = collect(config('destination_facts'))
            ->map(function ($d) {
                return ['lat' => $d['lat'], 'lon' => $d['lon']];
            })
            ->values();

        $b = collect(config('destination_facts'))->keys();
        //dd($a);
        return layout('Offer')
            ->with('color', 'blue')
            ->with(
                'top',
                collect()->push(
                    component('Dotmap')
                        ->with('width', '1200')
                        ->is('center')
                        ->with('destination_dots', config('destination_dots'))
                        ->with('destination_facts', config('destination_facts'))
                        ->with('passivecities', $a)
                )
            )
            ->render();
    }

    public function userIndex($id = 27)
    {
        $user = User::findOrFail($id);

        $been = $user
            ->vars()
            ->destinationHaveBeen()
            ->map(function ($f) {
                return $f->flaggable->id;
            })
            ->values();
        // dd($wantsToGo);

        return layout('Offer')
            ->with('color', 'cyan')
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
                        component('Dotmap')
                            ->with('height', '300px')
                            ->is('center')
                            ->with(
                                'destination_dots',
                                config('destination_dots')
                            )
                            ->with(
                                'destination_facts',
                                config('destination_facts')
                            )
                            ->with('activecountries', $been)
                            ->with('passivecities', $been)
                    )
                    ->push(
                        component('Flex')
                            ->is('center')
                            ->with('items', [
                                component('UserImage')
                                    ->with('route', route('user.show', [$user]))
                                    ->with(
                                        'image',
                                        $user->imagePreset('small_square')
                                    )
                                    ->with('rank', $user->vars()->rank)
                                    ->with('size', 152)
                                    ->with('border', 7)
                            ])
                    )
                    ->br()
                    ->push(
                        component('Title')
                            ->is('white')
                            ->is('large')
                            ->is('center')
                            ->with('title', $user->vars()->name)
                    )
            )
            ->with('footer', region('FooterLight', ''))
            ->render();
    }
}
