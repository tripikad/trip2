<?php

namespace App\Http\Regions;

class CompanyOffers
{
    public function render($offers)
    {
        return component('Grid')
            ->with('widths', '1fr auto')
            ->with('gap', 4)
            ->with(
                'items',
                $offers->flatMap(function ($offer) {
                    return collect()
                        ->push(
                            component('OfferRow')
                                ->is($offer->status == 1 ? '' : 'unpublished')
                                ->with('offer', $offer)
                                ->with('route', route('offer.show', [$offer]))
                        )
                        ->push(
                            component('Button')
                                ->is('orange')
                                ->is('narrow')
                                ->is('small')
                                ->with('title', 'Muuda')
                        );
                })
            );
    }
}
