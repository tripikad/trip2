<?php

namespace App\Http\Regions;

use App\Offer;

class OfferSection
{
    public function render()
    {
        if (env('OFFERS_LAUNCH', false)) {
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
                        ->withHeight(spacer(24))
                        ->withBackground('blue')
                        ->withImage('./photos/map.png')
                        ->withItems(
                            collect()
                                ->spacer(3)
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
                                                                ->withRoute(route('offer.index'))
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
                                                                ->withRoute(route('offer.index'))
                                                        )
                                                        ->spacer(2)
                                                        ->merge(
                                                            $adventureOffers->flatMap(function ($offer, $index) {
                                                                return collect()->push(
                                                                    component('OfferRow')
                                                                        ->with('offer', $offer)
                                                                        ->with('route', route('offer.show', [$offer]))
                                                                );
                                                            })
                                                        )
                                                )
                                        )
                                )
                        )
                )
                ->push(
                    component('Section')
                        ->withBackground('blue')
                        ->withAlign('center')
                        ->withItems(
                            collect()
                                ->push(
                                    component('Button')
                                        ->is('orange')
                                        ->is('narrow')
                                        ->withTitle(trans('frontpage.index.offer.button'))
                                        ->withRoute(route('offer.index'))
                                )
                                ->spacer(3)
                        )
                )
                ->render()
                ->implode('');
        }
        return '';
    }
}
