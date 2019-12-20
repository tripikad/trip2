<?php

namespace App\Http\Regions;

class OfferPhotoSection
{
  public function render($photos)
  {
    return component('Section')
      ->withHeight(15)
      ->withBackground('gray-darker')
      ->withMargin(0)
      ->withWidth('100%')
      ->withItems(
        component('Flex')
          ->withGap(0)
          ->withScroll(true)
          ->withResponsive(false)
          ->withItems(
            $photos->map(function ($photo) {
              return component('Photo')->withImage($photo->imagePreset('small_square'));
            })
          )
      );
  }
}
