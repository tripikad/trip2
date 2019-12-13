<?php

namespace App\Http\Controllers;

use App\Offer;

class ExperimentsController extends Controller
{
    public function index()
    {
        $user = null;

        $offer = Offer::find(7);

        return layout('Full')
            ->withItems(
                component('Section')
                    ->withWidth('600px') // 1200
                    ->withHeight('335px') // 675
                    ->withBackground('blue')
                    ->withAlign('center')
                    ->withImage('./photos/map.png')
                    ->withItems(
                        collect()
                            ->spacer(2)
                            ->push(
                                component('Icon')
                                    ->with('icon', 'tripee_logo')
                                    ->with('width', 320)
                                    ->with('height', 110)
                            )
                            ->push(
                                component('Title')
                                    ->is('large')
                                    ->is('white')
                                    ->is('center')
                                    ->withTitle(trans('frontpage.index.offer.title'))
                                    ->withRoute(route('offer.index'))
                            )
                            ->spacer(3)
                            ->push(
                                component('Title')
                                    ->is('small')
                                    ->is('white')
                                    ->is('center')
                                    ->withTitle(trans('Hulludest seiklustest<br>rannapuhkuseni'))
                                    ->withRoute(route('offer.index'))
                            )
                    )
            )
            ->render();
    }
}
