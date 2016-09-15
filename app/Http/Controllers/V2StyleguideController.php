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

        $user1 = User::find(3);
        $user3 = User::find(5);
        $user2 = User::find(12);

        $posts = Content::whereType('forum')->latest()->skip(25)->take(3)->get();

        $news = Content::find(98479);

        $destination = Destination::find(4639);

        $destinations = Destination::select('id', 'name')->get();

        $travelmates = Content::whereType('travelmate')->latest()->skip(25)->take(6)->get();

        $blog = Content::find(97993);

        $images = Content::whereType('photo')->latest()->skip(2)->take(6)->get()
            ->map(function ($image) {
                return [
                    'id' => $image->id,
                    'small' => $image->imagePreset('small_square'),
                    'large' => $image->imagePreset('large'),
                    'meta' => component('Meta')->with('items', collect()
                        ->push(component('MetaLink')
                            ->with('title', $image->vars()->title)
                        )
                        ->push(component('MetaLink')
                            ->with('title', $image->vars()->created_at)
                        )
                        ->push(component('MetaLink')
                            ->with('title', $image->user->vars()->name)
                            ->with('route', route('user.show', [$image->user]))
                        )
                    )->render(),
                ];
            });

        return view('v2.layouts.1col')

            ->with('content', collect()

                ->push(component('MetaLink')
                    ->with('title', 'Frontpage')
                    ->with('route', route('frontpage.index.v2'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'News')
                    ->with('route', route('news.index.v2'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Flight')
                    ->with('route', route('flight.index.v2'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Forum')
                    ->with('route', route('forum.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Travelmate')
                    ->with('route', route('travelmate.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Static pages')
                    ->with('route', route('static.index'))
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
