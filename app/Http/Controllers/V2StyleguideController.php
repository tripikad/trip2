<?php

namespace App\Http\Controllers;

use App\User;
use App\Content;
use App\Destination;

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

        return view('v2.layouts.1col')

            ->with('content', collect()

                ->push(component('Map')
                    //->with('left', null)
                    //->with('top', null)
                )

                ->push(component('Meta')->with('items', collect()
                        ->push(component('MetaLink')
                            ->with('title', 'News')
                            ->with('route', route('news.index'))
                        )
                        ->push(component('MetaLink')
                            ->with('title', 'Forum')
                            ->with('route', route('forum.index'))
                        )
                        ->push(component('MetaLink')
                            ->with('title', 'Flight')
                            ->with('route', route('flight.index'))
                        )
                        ->push(component('MetaLink')
                            ->with('title', 'Static pages')
                            ->with('route', route('static.index'))
                        )
                    )
                )

                ->push(component('DestinationBar')
                    ->with('route', route('destination.show', [$destination]))
                    ->with('title', $destination->name)
                    ->with('subtitle', collect()
                        ->push('Aasia')
                        ->push('Indoneesia')
                    )
                )

                // ->push(component('Map'))

                ->merge($posts->map(function ($post) {
                    return region('ForumRow', $post);
                }))

                ->push(component('Block')
                    ->is('uppercase')
                    ->with('title', 'Tripikad räägivad')
                    ->with('content', $posts->map(function ($post) {
                        return region('ForumRowSmall', $post);
                    })
                    )
                )

                ->push(component('Alert'))

                ->push(component('Form')
                    ->with('route', route('styleguide.form'))
                    ->with('fields', collect()
                        ->push(component('FormTextarea')
                            ->with('name', 'body')
                            ->with('placeholder', trans('comment.create.field.body.title'))
                        )
                        ->push(component('FormCheckbox')
                            ->with('name', 'check')
                            ->with('label', 'Subscribe to comment')
                        )
                        ->push(component('FormSelect')
                            ->with('name', 'destination')
                            ->with('options', $destinations)
                            ->with('placeholder', 'Just select')
                            ->with('helper', 'Press E to select')
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('comment.create.submit.title'))
                        )
                    )
                )

                ->push(component('Badge')->with('title', 200))

                ->push(component('Button')
                    ->with('icon', 'icon-facebook')
                    ->with('title', 'Button')
                    ->with('route', route('styleguide.index'))
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
}
