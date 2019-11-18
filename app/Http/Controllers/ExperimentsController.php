<?php

namespace App\Http\Controllers;

use App\Destination;
use App\User;

class ExperimentsController extends Controller
{
    public function index()
    {
        $t1 = '
### flightmap:TLL,HEL,JFK,POM

[[flightmap:TLL,HEL,JFK,POM]]

Tõime allpool välja valiku enamjaolt 4-5 päevasteks linnapuhkusteks. Piletihinnas sisaldub nii äraantav pagas kui toitlustamine lennuki pardal.';

        $t2 = 'Hea kvaliteedi ning hinnasuhtega hotellivalik on Istanbulis väga hea.
            Kui otsid soodsa hinnaga öömaja, siis soovitame parima ülevaate ja hinna saamiseks kasutada hotellihindade võrdlusportaali HotelsCombined.ee.';

        $b = "
Hello world

[[flightmap:TLL,LAX]]
        
        ";

        $a = collect(['TLL', 'JFK', 'LAX'])->map(function ($a) {
            return collect(config('airports'))
                ->where('iata', $a)
                ->first();
        });

        // dd(
        //     collect(config('airports'))
        //         ->slice(0, 10)
        //         ->where('iata', 'GKA')
        //         ->first()
        // );

        return layout('Two')
            //->with('color', 'blue')
            ->with(
                'content',
                collect()
                    ->push(component('Body')->with('body', format_body($t1)))
                    ->pushWhen(
                        false,
                        component('Dotmap')
                            ->is('center')
                            ->with('height', '300px')
                            ->with(
                                'destination_dots',
                                config('destination_dots')
                            )
                            ->with('lines', $a)
                            ->with('mediumdots', $a->withoutLast())
                            ->with('largedots', [$a->last()])
                            ->with('linecolor', 'blue')
                            ->with('mediumdotcolor', 'white')
                            ->with('largedotcolor', 'white')
                    )
                    ->push(component('Body')->with('body', format_body($t2)))
            )
            ->with('sidebar', ['a'])
            ->render();
    }

    public function destinationIndex()
    {
        $ds = Destination::skip(100)
            ->take(100)
            ->skip(200)
            ->get();
        //dd($ds);
        return layout('One')
            //->with('color', 'blue')
            ->with(
                'content',
                $ds
                    ->map(function ($d) {
                        $name =
                            $d->vars()->isContinent() && $d->vars()->facts()
                                ? ''
                                : json_encode(
                                    $d->vars()->facts(),
                                    JSON_PRETTY_PRINT
                                );
                        return collect()
                            ->push(
                                component('Title')
                                    //->is('white')
                                    ->is('small')
                                    ->with('title', $d->name)
                            )
                            ->push(
                                component('Code')
                                    ->is('gray')
                                    ->with(
                                        'code',
                                        "
name: {$d->name}
parent: {$d->getAncestors()->map->name}
{$name}
                                              "
                                    )
                            );
                        // ->push(
                        //     component('Dotmap')
                        //         ->with(
                        //             'destination_dots',
                        //             config('destination_dots')
                        //         )
                        //         ->with('areas', [$d->id])
                        // );
                    })
                    ->flatten()
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
                            ->with('areas', $been)
                            ->with('mediumdots', $been)
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
