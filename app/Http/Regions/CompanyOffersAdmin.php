<?php

namespace App\Http\Regions;

class CompanyOffersAdmin
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
                                ->is('narrow')
                                ->is('small')
                                ->with('title', trans('offer.admin.edit'))
                                ->with(
                                    'route',
                                    route('offer.admin.edit', [$offer, 'redirect' => 'company.admin.index'])
                                )
                        );
                })
            );
    }
}
