<?php

namespace App\Http\Regions;

class DestinationPhotoSectionHeader
{
  public function render($loggedUser, $destination)
  {
    return component('Flex')
      ->withJustify('space-between')
      ->withAlign('center')
      ->withItems(
        collect()
          ->push(
            component('BlockTitle')
              ->is('white')
              ->with('title', trans('frontpage.index.photo.title'))
              ->with(
                'route',
                route('photo.index', [
                  'destination' => $destination->id
                ])
              )
          )
          ->pushWhen(
            $loggedUser && $loggedUser->hasRole('regular'),
            component('Button')
              ->is('narrow')
              ->is('small')
              ->with('title', trans('content.photo.create.title'))
              ->with('route', route('photo.create'))
          )
      );
  }
}
