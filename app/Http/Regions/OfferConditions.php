<?php

namespace App\Http\Regions;

class OfferConditions
{
    public function render($offer)
    {
        return component('FlexGrid')
            ->withCols(2)
            ->withGap(4)
            ->withItems(
                collect()
                    ->push(
                        collect()
                            ->push(
                                component('Title')
                                    ->is('small')
                                    ->with('title', trans('offer.show.included'))
                            )
                            ->push(component('Body')->with('body', format_body($offer->data->included)))
                    )
                    ->push(
                        collect()
                            ->push(
                                component('Title')
                                    ->is('small')
                                    ->with('title', trans('offer.show.notincluded'))
                            )
                            ->push(component('Body')->with('body', format_body($offer->data->notincluded)))
                            ->spacer(2)
                            ->push(
                                component('Title')
                                    ->is('small')
                                    ->with('title', trans('offer.show.extras'))
                            )
                            ->push(component('Body')->with('body', format_body($offer->data->extras)))
                    )
            );
    }
}
