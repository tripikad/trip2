<?php

namespace App\Http\Controllers;

class StyleguideController extends Controller
{
    public function index()
    {
        return view('v2.layouts.1col')
            ->with('content', collect()


                ->push(component('Body')
                    ->is('responsive')
                    ->with('body', '
                        <p>Ennui flannel offal next level bitters four loko listicle synth church-key you probably havent heard of them keffiyeh sriracha.</p><img src="photos/social.jpg" /><p>Trade 90 cold-pressed beard photo booth selvage craft.</p><h3>H3 Gentrify etsy chartreuse</h3><p> trade 90 cold-pressed beard photo booth selvage craft. <a href="">Ennui flannel offal</a> next level bitters four loko listicle synth church-key.<ul><li>You probably havent</li><li>Heard</li><li>of them</li></ul>keffiyeh sriracha.</p><h4>H4 Gentrify etsy chartreuse</h4><p> trade 90 cold-pressed beard photo booth selvage craft</p>
                    ')
                )

                ->push(component('Button')->with('title', 'Button'))

                ->push(component('Arc'))
            )
            ->with('footer', region('Footer'));
    }
}
