<?php

namespace App\Http\Regions;

use App\Offer;

class FrontpageOfferSection
{
    public function render()
    {
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
                            ->push(
                                component('FlexGrid')
                                    ->withGap(4)
                                    ->withItems(
                                        collect()
                                            ->push(
                                                component('BlockTitle')
                                                    ->is('white')
                                                    ->withTitle(trans('offer.style.adventure.multiple'))
                                            )
                                            ->push(
                                                component('BlockTitle')
                                                    ->is('white')
                                                    ->withTitle(trans('offer.style.package.multiple'))
                                            )
                                    )
                            )
                            ->spacer(2)
                            ->push(
                                component('FlexGrid')
                                    ->withGap(4)
                                    ->withItems(
                                        collect()
                                            ->push(
                                                $adventureOffers->flatMap(function ($offer, $index) {
                                                    return collect()
                                                        ->push(
                                                            component('OfferRow')
                                                                ->with('offer', $offer)
                                                                ->with('route', route('offer.show', [$offer]))
                                                        )
                                                        ->spacer(2);
                                                })
                                            )
                                            ->push(
                                                $packageOffers->flatMap(function ($offer, $index) {
                                                    return collect()
                                                        ->push(
                                                            component('OfferRow')
                                                                ->with('offer', $offer)
                                                                ->with('route', route('offer.show', [$offer]))
                                                        )
                                                        ->spacer(2);
                                                })
                                            )
                                    )
                            )
                    )
            );
    }
}
