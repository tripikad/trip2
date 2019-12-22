<?php

namespace App\Http\Regions;

class UserPhotoSectionHeader
{
  public function render($user)
  {
    return component('BlockTitle')
      ->is('white')
      ->with('title', trans('frontpage.index.photo.title'))
      ->with('route', route('photo.user', [$user->id]));
  }
}
