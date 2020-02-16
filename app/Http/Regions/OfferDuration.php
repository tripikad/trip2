<?php

namespace App\Http\Regions;

class OfferDuration
{
    public function render($offer)
    {
        return component('Flex')
            ->with('justify', 'center')
            ->with(
                'items',
                collect()
                    ->push(
                        component('Title')
                            ->is('small')
                            ->is('center')
                            ->is('white')
                            ->with('title', $offer->duration_formatted)
                    )
                    ->push(
                        component('Title')
                            ->is('small')
                            ->is('center')
                            ->is('white')
                            ->is('semitransparent')
                            ->with('title', $offer->start_at_formatted . ' → ' . $offer->end_at_formatted)
                    )
            );
    }
}
