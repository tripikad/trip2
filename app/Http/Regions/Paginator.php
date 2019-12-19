<?php

namespace App\Http\Regions;

class Paginator
{
  public function render($paginator, $currentDestination = null, $currentTopic = null)
  {
    return $paginator
      ->appends(
        collect()
          ->putWhen($currentDestination, 'destination', $currentDestination)
          ->putWhen($currentTopic, 'topic', $currentTopic)
          ->all()
      )
      ->links('components.Paginator.Paginator');
  }
}
