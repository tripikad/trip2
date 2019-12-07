<?php

namespace App\Http\Controllers\Styleguide;

use App\Http\Controllers\Controller;

class ColorsController extends Controller
{
  public function index()
  {
    return layout('Two')
      ->with('title', 'Styles')
      ->with(
        'content',
        collect()
          ->push(region('StyleguideMenu'))
          ->push(component('Title')->with('title', 'Colors'))
          ->merge($this->colors())
      )
      ->render();
  }

  public function colors()
  {
    return collect(styles())
      ->filter(function ($value, $key) {
        return !ends_with($key, '-hover') && starts_with($value, 'hsl');
      })
      ->map(function ($value, $key) {
        return component('StyleColor')
          ->with('key', $key)
          ->with('value', $value);
      });
  }
}
