<?php

namespace App\Http\Regions;

class Paginator
{
    public function render($paginator, $currentDestination = null, $currentTopic = null)
    {
        return $paginator
            ->appends(collect()
                ->putWhen($currentDestination, 'destination', $currentDestination)
                ->putWhen($currentTopic, 'topic', $currentTopic)
                ->all()
            )
            ->links('v2.components.Paginator.Paginator');
    }
}
