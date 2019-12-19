<?php

namespace App\Http\Regions;

class DestinationHeaderAbout
{
  public function render($destination, $user)
  {
    return collect()
      ->push(
        component('Title')
          ->is('large')
          ->is('white')
          ->with('title', $destination->name)
      )
      ->push(region('DestinationFacts', $destination))
      ->render()
      ->implode('<br />');
  }
}
