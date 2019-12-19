<?php

namespace App\Http\Regions;

class FrontpageShortnews
{
  public function render($news)
  {
    return collect()
      ->push(
        component('BlockTitle')
          ->with('title', trans('frontpage.index.shortnews.title'))
          ->with('route', route('shortnews.index'))
      )
      ->push(
        component('FlexGrid')
          ->with('gap', 1)
          ->with('cols', 4)
          ->with(
            'items',
            $news->map(function ($new) {
              return region('ShortnewsCard', $new);
            })
          )
      );
  }
}
