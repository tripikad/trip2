<?php

namespace App\Http\Controllers;

class OfferController extends Controller
{
    public function index()
    {
        return layout('Two')
            ->with(
                'header',
                region(
                    'StaticHeader',
                    collect()->push(
                        component('Title')
                            ->is('large')
                            ->with(
                                'title',
                                trans('offers.index.title')
                            )
                    )
                )
            )
            ->with(
                'content',
                collect()->push(
                    component('OfferRows')->with(
                        'title',
                        'I am Offers'
                    )
                )
            )
            ->with(
                'sidebar',
                collect()->push(
                    component('Title')
                        ->is('small')
                        ->with('title', 'Sample title')
                )
            )
            ->render();
    }
}
