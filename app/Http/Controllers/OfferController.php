<?php

namespace App\Http\Controllers;

class OfferController extends Controller
{
    public function index()
    {
        return layout('Two')
            ->with('head_robots', 'noindex')
            ->with('background', component('BackgroundMap'))

            ->with(
                'header',
                region(
                    'StaticHeader',
                    collect()->push(
                        component('Title')
                            ->is('large')
                            ->with('title', trans('offers.index.title'))
                    )
                )
            )
            ->with('content', collect()->push(component('Offers')))
            //->with('sidebar', collect()->push(component('OfferDetails')))
            ->render();
    }
}
