<?php

namespace App\Http\Regions;

class OfferDetails
{
    public function render($offer)
    {
        $isPackage = $offer->style == 'package';

        return component('Flex')
            ->with('justify', 'center')
            ->with('gap', 'sm')
            ->with(
                'items',
                collect()
                    ->push(
                        component('Title')
                            ->is('smallest')
                            ->is('white')
                            ->is('semitransparent')
                            ->with('title', 'Firma')
                    )
                    ->push(
                        component('Title')
                            ->is('smallest')
                            ->is('white')
                            ->with('title', $offer->user->name)
                    )
                    ->pushWhen(
                        $offer->data->guide !== '',
                        component('Title')
                            ->is('smallest')
                            ->is('white')
                            ->is('semitransparent')
                            ->with('title', 'Giid')
                    )
                    ->pushWhen(
                        $offer->data->guide !== '',
                        component('Title')
                            ->is('smallest')
                            ->is('white')
                            ->with('title', $offer->data->guide)
                    )
                    ->pushWhen(
                        $offer->data->size !== '',
                        component('Title')
                            ->is('smallest')
                            ->is('white')
                            ->is('semitransparent')
                            ->with('title', 'Grupi suurus')
                    )
                    ->pushWhen(
                        $offer->data->size !== '',
                        component('Title')
                            ->is('smallest')
                            ->is('white')
                            ->with('title', $offer->data->size)
                    )
                    ->push('&nbsp;&nbsp;&nbsp;')
                    ->pushWhen(
                        $isPackage && $offer->data->url,
                        component('Title')
                            ->is('smallest')
                            ->is('white')
                            ->withExternal(true)
                            ->withTitle(trans('offer.show.url'))
                            ->withRoute($offer->data->url)
                    )
            );
    }
}
