<?php

namespace App\Http\Controllers;

use App\User;
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
                            ->with('title', 'Travelmate')
                            ->with('route', route('travelmate.index'))
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

                ->push(component('BlogCard')
                    ->with('title', $blog->title)
                    ->with('route', route('content.show', ['blog', $blog]))
                    ->with('profile', component('ProfileImage')
                        ->with('route', route('user.show', [$blog->user]))
                        ->with('image', $blog->user->imagePreset('small_square'))
                        ->with('rank', $blog->user->vars()->rank)
                    )
                    ->with('meta', component('Meta')->with('items', collect()
                        ->push(component('MetaLink')
                            ->with('title', $blog->user->vars()->name)
                            ->with('route', route('user.show', [$blog->user]))
                        ))
                    )
                )

                // ->push(component('Map'))

                ->merge($posts->map(function ($post) {
                    return region('ForumRow', $post);
                }))

                ->push(region('ForumSidebar', $posts))

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
                            ->with('multiple', false)
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('comment.create.submit.title'))
                        )
                        ->push(component('ImageUpload')
                            ->with('dictfallbackmessage', trans('site.dropzone.fallback.message'))
                            ->with('dictfallbacktext', trans('site.dropzone.fallback.text'))
                            ->with('dictmaxfilesexceeded', trans('site.dropzone.max.files.exceeded'))
                            ->with('dictfiletoobig', trans('site.dropzone.file.size.exceeded'))
                            ->with('dictremovefile', trans('site.dropzone.file.remove'))
                            ->with('dictdefaultmessage', trans('site.dropzone.default'))
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

    public function store()
    {
        $image = Request::file('image');

        $imagename = 'image-'.rand(1, 3).'.'.$image->getClientOriginalExtension();

        return Response::json([
            'image' => $imagename,
        ]);
    }
}
