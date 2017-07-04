<?php

namespace App\Http\Controllers;

use App\User;
use App\Content;

class V2ExperimentsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return layout('1col')

            ->with('content', collect()

                ->push(component('Title')
                    ->with('title', 'Auth forms')
                )

                ->push(component('MetaLink')
                    ->with('title', 'Login')
                    ->with('route', route('experiments.loginform'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Register')
                    ->with('route', route('experiments.registerform'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Remember password')
                    ->with('route', route('experiments.passwordform'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Reset password')
                    ->with('route', route('experiments.resetform'))
                )

                ->push(component('Title')
                    ->with('title', 'Blogs')
                )

                ->push(component('MetaLink')
                    ->with('title', 'Blog: index')
                    ->with('route', route('experiments.blog.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Blog: show')
                    ->with('route', route('experiments.blog.show'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Blog: edit')
                    ->with('route', route('experiments.blog.edit'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Blog: profile')
                    ->with('route', route('experiments.blog.profile'))
                )

                ->push(component('Title')
                    ->with('title', 'Misc')
                )

            )

            ->render();
    }

    public function map()
    {
        $userId = request()->get('userid', 3);
        $user = User::find($userId);

        $users = User::whereIn('role', ['admin', 'superuser'])->get();

        $havebeenCities = $user
            ->vars()
            ->destinationHaveBeen()
            ->map(function ($flag) {
                $destination = $flag->flaggable;
                if ($destination->vars()->isPlace()
                    && isset(config('cities')[$destination->id])
                ) {
                    return [
                        'lat' => config('cities')[$destination->id]['lat'],
                        'lon' => config('cities')[$destination->id]['lon'],
                    ];
                }
            })
            ->reject(function ($flag) {
                return $flag == null;
            })
            ->values();

        $wanttogoCities = $user
            ->vars()
            ->destinationWantstogo()
            ->map(function ($flag) {
                $destination = $flag->flaggable;
                if ($destination->vars()->isPlace()
                    && isset(config('cities')[$destination->id])
                ) {
                    return [
                        'lat' => config('cities')[$destination->id]['lat'],
                        'lon' => config('cities')[$destination->id]['lon'],
                    ];
                }
            })
            ->reject(function ($flag) {
                return $flag == null;
            })
            ->values();

        $havebeenCountries = $user
            ->vars()
            ->destinationHaveBeen()
            ->map(function ($flag) {
                $destination = $flag->flaggable;
                if ($destination->vars()->isCountry()) {
                    return $destination->id;
                }
            })
            ->reject(function ($flag) {
                return $flag == null;
            })
            ->values();

        $wanttogoCountries = $user
            ->vars()
            ->destinationWantstogo()
            ->map(function ($flag) {
                $destination = $flag->flaggable;
                if ($destination->vars()->isCountry()) {
                    return $destination->id;
                }
            })
            ->reject(function ($flag) {
                return $flag == null;
            })
            ->values();

        return layout('1col')

            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', 'Kus oled käinud / kuhu tahad minna')
                )
                ->push(component('Body')
                    ->with('body', 'Vali altpoolt toimetuse liige ja vaata tema kaarti. Vaikimisi näed <b>tom</b>i kaarti. Kui tead mistahes kasutaja IDd, võid selle aadressiribale kirjutada.')
                )
                ->push(component('Meta')->with('items', $users
                    ->map(function ($user) {
                        return component('Tag')
                            ->is('cyan')
                            ->with('title', $user->name)
                            ->with('route', route(
                                'experiments.map',
                                ['userid' => $user->id]
                            ));
                    })
                ))
                ->push(component('Dotmap')
                    ->with('dots', config('dots'))
                    ->with('havebeen_cities', $havebeenCities)
                    ->with('wanttogo_cities', $wanttogoCities)
                    ->with('havebeen_countries', $havebeenCountries)
                    ->with('wanttogo_countries', $wanttogoCountries)
                )
            )
            ->render();
    }
}
