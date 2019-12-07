<?php

namespace App\Http\Regions;

class OfferAdminButtons
{
    public function render()
    {
        return component('FlexGrid')
            ->with('cols', 2)
            ->with(
                'items',
                collect(config('offer.styles'))
                    ->map(function ($style) {
                        return component('Button')
                            ->with('title', trans("offer.admin.create.style.$style"))
                            ->with('route', route('offer.admin.create', [$style]));
                    })
                    ->push('&nbsp;')
            );
    }
}
