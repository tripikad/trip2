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


        return view('v2.layouts.1col')

            ->with('content', collect()

                ->push(component('Meta')->with('items', collect()
                        ->push(component('Link')
                            ->with('title', 'News')
                            ->with('route', route('news.index'))
                        )
                        ->push(component('Link')
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
                        ->push(component('FormButton')
                            ->with('title', trans('comment.create.submit.title'))
                        )
                    )
                )

                ->push(component('Badge')->with('title', 200))

                ->push(component('Block')
                    ->with('title', 'Hello')
                    ->with('subtitle', 'Soovid kaaslaseks eksperti oma esimesele matkareisile? Lihtsalt seltsilist palmi alla?')
                    ->with('content', collect()
                        ->push(component('Body')
                            ->with('body', 'Siit leiad omale sobiva reisikaaslase. Kasuta ka allpool olevat filtrit soovitud tulemuste saamiseks.')
                        )
                        ->push(component('LinkBar')
                            ->with('title', 'Kasutustingimused')
                        )
                        ->push(component('Button')
                            ->with('title', 'Button')
                        )
                    )
                )

                ->push(component('Body')
                    ->is('responsive')
                    ->with('body', format_body('Ennui flannel offal next level bitters four loko listicle synth church-key you probably havent heard of them keffiyeh sriracha.\n\nMeditation retro shabby chic food truck, master cleanse offal tofu. Taxidermy skateboard post-ironic, freegan helvetica pickled art party tilde kinfolk stumptown.</p><table><tr><th>Synth</th><th>Skateboard</th><th>Freegan</th></tr><tr><td>Skateboard</td><td>Freegan</td><td>Beard</td></tr></table><p>Meditation retro shabby chic food truck, master cleanse offal tofu. Taxidermy skateboard post-ironic, freegan helvetica pickled art party tilde kinfolk stumptown.'))
                )

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

        sleep(2);

        return redirect()->route('styleguide.index')->with('info', 'We are back');
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
