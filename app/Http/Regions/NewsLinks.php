<?php

namespace App\Http\Regions;

class NewsLinks
{
    public function render()
    {
        return collect()
      ->push(
        component('Link')
          ->is('white')
          ->with('title', trans('menu.news.news'))
          ->with('route', route('news.index'))
      )
      ->push(
        component('Link')
          ->is('white')
          ->with('title', trans('menu.news.shortnews'))
          ->with('route', route('shortnews.index'))
      );
    }
}
