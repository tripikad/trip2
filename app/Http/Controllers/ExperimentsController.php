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
                    ->padding(10)
                    ->withWidth(styles('mobile-large-width'))
                    ->height('100vh')
                    ->withBackground('blue')
                    ->withInnerBackground('white')
                    ->withInnerPadding(2)
                    ->withItems(
                        component('FormAccordion')->withItems(
                            collect($offer->data->hotels)
                                ->map(function ($hotel) {
                                    return $hotel->name;
                                })
                                ->push('aaa')
                        )
                    )
            )
            ->render();
    }
}
