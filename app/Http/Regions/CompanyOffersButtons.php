<?php

namespace App\Http\Regions;

class CompanyOffersButtons
{
  public function render($user)
  {
    return component('Grid')
      ->withCols(3)
      ->withGap(1)
      ->withItems(
        collect(config('offer.styles'))
          ->map(function ($style, $index) {
            return component('Button')
              ->is('large')
              ->is($index > 1 ? 'cyan' : '')
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
