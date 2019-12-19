<?php

namespace App\Http\Regions;

class OfferConditions
{
  public function render($offer)
  {
    return component('FlexGrid')
      ->withCols(2)
      ->withGap(4)
      ->withDebug()
      ->withItems(
        collect()
          ->pushWhen(
            $offer->data->included,
            collect()
              ->push(
                component('Title')
                  ->is('small')
                  ->with('title', trans('offer.show.included'))
              )
              ->push(component('Body')->with('body', format_body($offer->data->included)))
          )
          ->pushWhen(
            $offer->data->notincluded || $offer->data->extras,
            collect()
              ->pushWhen(
                $offer->data->notincluded,
                component('Title')
                  ->is('small')
                  ->with('title', trans('offer.show.notincluded'))
              )
              ->pushWhen(
                $offer->data->notincluded,
                component('Body')->with('body', format_body($offer->data->notincluded))
              )
              ->spacer(2)
              ->pushWhen(
                $offer->data->extras,
                component('Title')
                  ->is('small')
                  ->with('title', trans('offer.show.extras'))
              )
              ->pushWhen($offer->data->extras, component('Body')->with('body', format_body($offer->data->extras)))
          )
      );
  }
}
