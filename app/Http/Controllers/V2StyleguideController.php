<?php

namespace App\Http\Controllers;

use Request;
use Response;
use App\Image;
use App\Content;
use App\Destination;

class V2StyleguideController extends Controller
{
    public function index()
    {
        session()->keep('info');

        $user = auth()->user();

        return layout('1col')

            ->with('content', collect()

                ->push(component('Title')
                    ->with('title', 'Uue tripi eelvaade')
                )

                ->push(component('MetaLink')
                    ->with('title', 'Esikülg')
                    ->with('route', route('v2.frontpage.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Uudised')
                    ->with('route', route('v2.news.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Lennupakkumised')
                    ->with('route', route('v2.flight.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Foorum')
                    ->with('route', route('v2.forum.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Reisikaaslased')
                    ->with('route', route('v2.travelmate.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Staatilised lehed')
                    ->with('route', route('v2.static.index'))
                )
                ->pushWhen($user && $user->hasRole('admin'), component('MetaLink')
                    ->with('title', 'Toimetuse foorum')
                    ->with('route', route('v2.internal.index'))
                )

            )

            ->render();
    }

    public function form()
    {
        dump(request()->all());

        // return redirect()->route('styleguide.index')->with('info', 'We are back');
    }

    public function flag()
    {
        if (request()->has('value')) {
            return response()->json([
                'value' => request()->get('value') + 1,
            ]);
        }
        //return abort(404);
    }

    public function store()
    {
        $image = Request::file('image');

        $imagename = 'image-'.rand(1, 3).'.'.$image->getClientOriginalExtension();

        return Response::json([
            'image' => $imagename,
        ]);
    }
}
