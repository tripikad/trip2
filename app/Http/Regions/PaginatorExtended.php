<?php

namespace App\Http\Regions;

class PaginatorExtended
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
      ->links('components.PaginatorExtended.PaginatorExtended');
    }
}
