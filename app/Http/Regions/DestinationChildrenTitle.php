<?php

namespace App\Http\Regions;

class DestinationChildrenTitle
{
    public function render($destination, $childrens)
    {
        return collect()
      ->pushWhen(
        $destination->isContinent(),
        component('Title')
          ->is('white')
          ->with(
            'title',
            trans_choice('destination.show.children.continent', $childrens->count(), [
              'count' => $childrens->count()
            ])
          )
      )
      ->pushWhen(
        $destination->isCountry(),
        component('Title')
          ->is('white')
          ->with(
            'title',
            trans_choice('destination.show.children.country', $childrens->count(), [
              'count' => $childrens->count()
            ])
          )
      )
      ->pushWhen(
        $destination->isCity(),
        component('Title')
          ->is('white')
          ->with(
            'title',
            trans_choice('destination.show.children.city', $childrens->count(), [
              'count' => $childrens->count()
            ])
          )
      )
      ->render()
      ->implode('');
    }
}
