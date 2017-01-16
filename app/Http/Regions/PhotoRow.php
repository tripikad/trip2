<?php

namespace App\Http\Regions;

class PhotoRow
{
    public function render($photos)
    {
        return component('PhotoRow')->with('content', $photos->map(function ($photo) {
            return component('PhotoCard')
                ->with('small', $photo->imagePreset('small_square'))
                ->with('large', $photo->imagePreset('large'))
                ->with('meta', trans('content.photo.meta', [
                    'title' => $photo->vars()->title,
                    'username' => $photo->user->vars()->name,
                    'created_at' => $photo->vars()->created_at
                ]));
        }));
    }
}
