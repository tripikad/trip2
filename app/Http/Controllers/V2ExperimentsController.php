<?php

namespace App\Http\Controllers;

use App\Content;
use App\User;

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

            )

            ->render();
    }

    public function map()
    {
        $user = User::find(12);
        $havebeen = $user
            ->vars()
            ->destinationHaveBeen()
            ->map(function($flag) {
                $destination = $flag->flaggable;
                if ($destination->vars()->isPlace()
                    && isset(config('cities')[$destination->id])
                ) {
                    return [
                        'lat' => config('cities')[$destination->id]['lat'],
                        'lon' => config('cities')[$destination->id]['lon']
                    ];
                }
            })
            ->reject(function($flag) { return $flag == null; })
            ->values();

        return layout('1col')
            ->with('content', collect()
                ->push(component('Dotmap')
                    ->with('dots', config('dots'))
                    ->with('countries', $havebeen)
                )
            )
            ->render();
    }
}
