<?php

namespace App\Http\Controllers;

use App\Offer;

class ExperimentsController extends Controller
{
    public function index()
    {
        $user = null;

        $adventureOffers = Offer::public()
            ->orderBy('start_at')
            ->with(['user:id,name', 'startDestinations', 'endDestinations'])
            ->where('style', '<>', 'package')
            ->take(2)
            ->get();

        $packageOffers = Offer::public()
            ->orderBy('start_at')
            ->with(['user:id,name', 'startDestinations', 'endDestinations'])
            ->where('style', '=', 'package')
            ->take(2)
            ->get();

        //   dd($adventureOffers);

        return layout('Full')
            ->withItems(
                collect()->push(
                    component('Section')
                        ->withBackground('blue')
                        ->withPadding(2)
                        ->withAlign('center')
                        ->withItems(
                            collect()
                                ->spacer()
                                ->push(
                                    component('Title')
                                        ->is('large')
                                        ->is('white')
                                        ->is('center')
                                        ->withTitle(trans('offer.index'))
                                )
                                ->spacer()
                                ->push(
                                    component('Title')
                                        ->is('small')
                                        ->is('white')
                                        ->is('center')
                                        ->withTitle('Tripi sõprade poolt pakutavad reisid, seiklustest rannapuhkuseni')
                                )
                                ->spacer(2)
                                ->push(
                                    component('Button')
                                        ->is('orange')
                                        ->is('narrow')
                                        ->withTitle('Vaata kõiki reisipakkumisi')
                                )
                                ->spacer(4)
                                ->push(
                                    component('FlexGrid')
                                        ->withGap(4)
                                        ->withItems(
                                            collect()
                                                ->push(
                                                    collect()
                                                        ->push(
                                                            component('BlockTitle')
                                                                ->is('white')
                                                                ->withTitle('Seiklusreisid')
                                                        )
                                                        ->spacer(2)
                                                        ->merge(
                                                            $adventureOffers->flatMap(function ($offer, $index) {
                                                                return collect()
                                                                    ->push(
                                                                        component('OfferRow')
                                                                            ->with('offer', $offer)
                                                                            ->with(
                                                                                'route',
                                                                                route('offer.show', [$offer])
                                                                            )
                                                                    )
                                                                    ->spacer(2);
                                                            })
                                                        )
                                                )
                                                ->push(
                                                    collect()
                                                        ->push(
                                                            component('BlockTitle')
                                                                ->is('white')
                                                                ->withTitle('Seiklusreisid')
                                                        )
                                                        ->spacer(2)
                                                        ->merge(
                                                            $packageOffers->flatMap(function ($offer, $index) {
                                                                return collect()
                                                                    ->push(
                                                                        component('OfferRow')
                                                                            ->with('offer', $offer)
                                                                            ->with(
                                                                                'route',
                                                                                route('offer.show', [$offer])
                                                                            )
                                                                    )
                                                                    ->spacer(2);
                                                            })
                                                        )
                                                )
                                        )
                                )
                        )
                )
            )
            ->render();
    }
}
