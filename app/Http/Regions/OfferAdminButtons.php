<?php

namespace App\Http\Regions;

class OfferAdminButtons
{
    public function render($user)
    {
        return component('FlexGrid')
            ->with('cols', 3)
            ->with(
                'items',
                collect(config('offer.styles'))
                    ->map(function ($style) {
                        return component('Button')
                            ->is('large')
                            ->is('orange')
                            ->with('title', trans("offer.admin.create.style.$style"))
                            ->with('route', route('offer.admin.create', [$style]));
                    })
                    ->push(
                        component('Button')
                            ->is('large')
                            ->is('cyan')
                            ->with('title', trans('offer.admin.company.edit'))
                            ->with('route', route('company.edit', [$user]))
                    )
            );
    }
}
