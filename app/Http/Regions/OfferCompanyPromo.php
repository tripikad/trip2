<?php

namespace App\Http\Regions;

class OfferCompanyPromo
{
  public function render()
  {
    return component('Section')
      ->withBackground('blue')
      ->withAlign('center')
      ->withItems(
        collect()
          ->spacer(8)
          ->push(
            component('Flex')->withItems(
              collect()
                ->push(
                  component('Icon')
                    ->is('white')
                    ->withSize('xxl')
                    ->withIcon('icon-pin')
                )
                ->push(
                  component('Icon')
                    ->is('white')
                    ->withSize('xxl')
                    ->withIcon('icon-tickets')
                )
                ->push(
                  component('Icon')
                    ->is('white')
                    ->withSize('xxl')
                    ->withIcon('icon-star')
                )
            )
          )
          ->spacer(2)
          ->push(
            component('Title')
              ->is('white')
              ->is('large')
              ->is('center')
              ->withTitle(trans('offer.index.company.title'))
          )
          ->spacer(2)
          ->push(
            component('Body')
              ->is('white')
              ->withBody(format_body(trans('offer.index.company.description', ['email' => config('offer.email')])))
          )
          ->spacer(4)
      );
  }
}
