<?php

namespace App\Http\Regions;

use App\Offer;

class FrontpageOfferSection
{
    public function render()
    {
        if (env('OFFERS_ENABLED', false)) {
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

            return collect()
                ->push(
                    component('Section')
                        ->withBackground('blue')
                        ->withPadding(3)
                        ->withAlign('center')
                        ->withItems(
                            collect()
                                ->spacer()
                                ->push(
                                    component('Title')
                                        ->is('large')
                                        ->is('white')
                                        ->is('center')
                                        ->withTitle(trans('frontpage.index.offer.title'))
                                        ->withRoute(route('offer.index'))
                                )
                                ->spacer()
                                ->push(
                                    component('Title')
                                        ->is('small')
                                        ->is('white')
                                        ->is('center')
                                        ->withTitle(trans('frontpage.index.offer.about'))
                                        ->withRoute(route('offer.index'))
                                )
                                ->spacer(2)
                                ->push(
                                    component('Button')
                                        ->is('orange')
                                        ->is('narrow')
                                        ->is('large')
                                        ->withTitle(trans('frontpage.index.offer.button'))
                                        ->withRoute(route('offer.index'))
                                )
                        )
                )
                ->push(
                    component('Section')
                        ->withHeight(spacer(24))
                        ->withBackground('blue')
                        ->withItems(
                            collect()
                                ->spacer(2)
                                ->push(
                                    component('FlexGrid')
                                        ->withGap(2)
                                        ->withItems(
                                            collect()
                                                ->push(
                                                    collect()
                                                        ->push(
                                                            component('BlockTitle')
                                                                ->is('white')
                                                                ->withTitle(trans('offer.style.adventure.multiple'))
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
                                                                ->withTitle(trans('offer.style.package.multiple'))
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
                ->render()
                ->implode('');
        }

        return '';
    }
}
