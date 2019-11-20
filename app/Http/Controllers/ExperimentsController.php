<?php

namespace App\Http\Controllers;

use App\Destination;
use App\User;

class ExperimentsController extends Controller
{
    public function index()
    {
        $d = Destination::select('id')->get();
        $d2 = Destination::countries()
            ->get()
            ->map(function ($d) {
                return $d
                    ->getAncestorsAndSelf()
                    ->pluck('name')
                    ->implode(' → ');
            })
            ->toJson(JSON_PRETTY_PRINT);
        dd(Destination::countries()->count());
        $areas = $d->pluck('id');
        $dots = $d
            ->map(function ($d) {
                return $d->vars()->snappedCoordinates();
            })
            ->filter()
            ->values();

        return layout('Offer')
            ->with('color', 'yellow')
            ->with(
                'top',
                collect()->push(
                    component('Dotmap')
                        ->is('center')
                        ->with('areas', $areas)
                        ->with('smalldots', $dots)
                )
            )
            ->render();
    }

    public function flightIndex()
    {
        $t1 = '
### flightmap:TLL,HEL,JFK,POM

[[flightmap:TLL,HEL,JFK,POM]]

Tõime allpool välja valiku enamjaolt 4-5 päevasteks linnapuhkusteks. Piletihinnas sisaldub nii äraantav pagas kui toitlustamine lennuki pardal.';

        // $a = collect(['TLL', 'JFK', 'LAX'])->map(function ($a) {
        //     return collect(config('airports'))
        //         ->where('iata', $a)
        //         ->first();
        // });

        return layout('Two')
            ->with(
                'content',
                collect()->push(
                    component('Body')->with('body', format_body($t1))
                )
            )
            ->with('sidebar', ['a'])
            ->render();
    }

    public function destinationIndex()
    {
        $ds = Destination::skip(50)
            ->take(50)
            ->get();

        return layout('Offer')
            ->with('color', 'blue')
            ->with(
                'content',
                $ds
                    ->map(function ($d) {
                        $name =
                            $d->isContinent() && $d->vars()->facts()
                                ? ''
                                : json_encode(
                                    $d->vars()->facts(),
                                    JSON_PRETTY_PRINT
                                );

                        $small = $d->vars()->facts()
                            ? [
                                [
                                    'lat' => snap($d->vars()->facts()->lat),
                                    'lon' => snap($d->vars()->facts()->lon)
                                ]
                            ]
                            : false;

                        return collect()
                            ->push(
                                component('Title')
                                    //->is('white')
                                    ->is('small')
                                    ->with('title', $d->name)
                            )
                            //                             ->push(
                            //                                 component('Code')
                            //                                     ->is('gray')
                            //                                     ->with(
                            //                                         'code',
                            //                                         "
                            // id:   {$d->id}
                            // name: {$d->name}
                            // parent: {$d->getAncestors()->map->name}
                            // { $name }
                            //                                               "
                            //                                     )
                            //                             );
                            ->push(
                                component('Dotmap')
                                    ->with('areas', [$d->id])
                                    ->with('smalldots', $small)
                            );
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
                        component('Flex')->with('items', [
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
