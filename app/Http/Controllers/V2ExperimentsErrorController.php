<?php

namespace App\Http\Controllers;

use Auth;

class V2ErrorController extends Controller
{
    public function show($code)
    {
        $userIsLogged = Auth::check();

        $title = '';
        $body = '';

        if ($code != 401) {
            $title = "error.$code.title";
        }
        if ($code == 401 && ! $userIsLogged) {
            $title = "error.$code.title.unlogged";
        }
        if ($code == 401 && $userIsLogged) {
            $title = "error.$code.title.logged";
        }

        if ($code != 401) {
            $body = "error.$code.body";
        }
        if ($code == 401 && ! $userIsLogged) {
            $body = "error.$code.body.unlogged";
        }
        if ($code == 401 && $userIsLogged) {
            $body = "error.$code.body.logged";
        }

        $color = ($code != 503) ? 'red' : '';

        return layout('1col')

            ->with('header', region('StaticHeader', collect()
                ->push(component('Title')
                    ->is($color)
                    ->is('large')
                    ->with('title', trans($title))
                )
            ))

            ->with('content', collect()
                ->push(component('Body')
                    ->is('responsive')
                    ->with('body', trans($body))
                )
                ->push('&nbsp;')
                ->push('&nbsp;')
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }
}
