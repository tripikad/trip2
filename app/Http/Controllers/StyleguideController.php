<?php

namespace App\Http\Controllers;

use App\User;
use App\Content;

class StyleguideController extends Controller
{
    public function index()
    {
        session()->keep('info');

        /*

        $user1 = User::find(3);
        $user3 = User::find(5);
        $user2 = User::find(12);

        $posts = Content::whereType('forum')->latest()->skip(24)->take(3)->get();

        */

        return view('v2.layouts.1col')
            ->with('content', collect()

                /*

                ->push(region('CommentCreateForm', $posts->first()))

                ->merge($posts->first()->comments->take(2)->map(function ($comment) {
                    return region('Comment', $comment);
                }))

                ->merge($posts->map(function ($post) {
                    return region('ForumItem', $post);
                }))

                */

                ->push(component('Alert'))

                ->push(region('NavbarDesktop'))

                ->push(region('NavbarMobile'))

                ->push(component('Form')
                    ->with('route', route('styleguide.form'))
                    ->with('fields', collect()
                        ->push(component('FormTextarea')
                            ->with('name', 'body')
                            ->with('placeholder', trans('comment.create.field.body.title'))
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('comment.create.submit.title'))
                        )
                    )
                )

                ->push(component('Badge')->with('title', 200))

                ->push(component('Block')
                    ->is('responsive')
                    ->with('title', 'Hello')
                    ->with('subtitle', 'Soovid kaaslaseks eksperti oma esimesele matkareisile? Lihtsalt seltsilist palmi alla?')
                    ->with('content', collect()
                        ->push(component('Body')
                            ->with('body', 'Siit leiad omale sobiva reisikaaslase. Kasuta ka allpool olevat filtrit soovitud tulemuste saamiseks.')
                        )
                        ->push(component('Link')
                            ->with('title', 'Kasutustingimused')
                        )
                        ->push(component('Button')
                            ->with('title', 'Button')
                        )
                    )
                )

                ->push(component('Body')
                    ->is('responsive')
                    ->with('body', '
                        <p>Ennui flannel offal next level bitters four loko listicle synth church-key you probably havent heard of them keffiyeh sriracha.</p><img src="photos/social.jpg" /><p>Meditation retro shabby chic food truck, master cleanse offal tofu. Taxidermy skateboard post-ironic, freegan helvetica pickled art party tilde kinfolk stumptown.</p><table><tr><th>Synth</th><th>Skateboard</th><th>Freegan</th></tr><tr><td>Skateboard</td><td>Freegan</td><td>Beard</td></tr></table><p>Meditation retro shabby chic food truck, master cleanse offal tofu. Taxidermy skateboard post-ironic, freegan helvetica pickled art party tilde kinfolk stumptown.</p><div class="iframeWrapper"><iframe width="560" height="315" src="https://www.youtube.com/embed/ATr37Yl17jg" frameborder="0" allowfullscreen></iframe></div><p>Trade 90 cold-pressed beard photo booth selvage craft.</p><h3>H3 Gentrify etsy chartreuse</h3><p>Trade 90 cold-pressed beard photo booth selvage craft. <a href="">Ennui flannel offal</a> next level bitters four loko listicle synth church-key.<ul><li>You probably havent</li><li>Heard</li><li>of them</li></ul>keffiyeh sriracha.</p><h4>H4 Gentrify etsy chartreuse</h4><p> trade 90 cold-pressed beard photo booth selvage craft</p>
                    ')
                )

                ->push(component('Button')
                    ->with('icon', 'icon-facebook')
                    ->with('title', 'Button')
                    ->with('route', route('styleguide.index'))
                )

                ->push(component('Arc'))

                ->push(region('FooterLight'))

                ->push(region('Footer'))

            )
            ->with('footer', '');
    }

    public function form()
    {
        dump(request()->all());

        sleep(2);

        return redirect()->route('styleguide.index')->with('info', 'We are back');
    }
}
