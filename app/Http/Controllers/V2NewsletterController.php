<?php

namespace App\Http\Controllers;

class V2NewsletterController extends Controller
{
    public function index()
    {
        return layout('2col')
            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')
            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->with('title', trans('menu.admin.newsletter'))
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
            ))
            ->with('content', collect()
                ->push('Sisu')
            )
            ->with('sidebar', collect())
            ->with('footer', region('FooterLight'))
            ->render();
    }
}
