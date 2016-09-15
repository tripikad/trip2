<?php

namespace App\Http\Controllers;

use App\User;
use App\Image;
use App\Content;
use App\Destination;
use Request;
use Response;

class V2StyleguideController extends Controller
{
    public function index()
    {
        session()->keep('info');

        return view('v2.layouts.1col')

            ->with('content', collect()

                ->push(component('MetaLink')
                    ->with('title', 'Frontpage')
                    ->with('route', route('v2.frontpage.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'News')
                    ->with('route', route('v2.news.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Flight')
                    ->with('route', route('v2.flight.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Forum')
                    ->with('route', route('forum.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Travelmate')
                    ->with('route', route('v2.travelmate.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Static pages')
                    ->with('route', route('v2.static.index'))
                )

            );
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
