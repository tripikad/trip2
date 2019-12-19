<?php

namespace App\Http\Regions;

class PhotoSection
{
  public function render($photos)
  {
    return component('Section')
      ->withBackground('gray-darker')
      ->withMargin(0)
      ->withWidth('100%')
      ->withItems(
        component('Flex')
          ->withGap(0)
          ->withScroll(true)
          ->withResponsive(false)
          ->withItems(
            $photos->map(function ($image) {
              return component('Image')->withImage($image->imagePreset('small_square'));
            })
          )
      );
  }
}
