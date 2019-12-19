<?php

namespace App\Http\Regions;

class OfferMap
{
  public function render($offer)
  {
    return component('Dotmap')
      ->withHeight(30)
      ->withDestinationFacts(config('destination_facts'))
      ->withLines([
        $offer->startDestinations
          ->first()
          ->vars()
          ->coordinates(),
        $offer->endDestinations
          ->first()
          ->vars()
          ->coordinates()
      ])
      ->withMediumdots([
        $offer->startDestinations
          ->first()
          ->vars()
          ->coordinates()
      ])
      ->withLargedots([
        $offer->endDestinations
          ->first()
          ->vars()
          ->coordinates()
      ]);
  }
}
