<?php

namespace App\Http\Regions;

class PhotoRow
{
    public function render($photos, $button = '')
    {   
        $content = $photos->map(function ($photo) {
            return component('PhotoCard')
                    ->with('small', $photo->imagePreset('small_square'))
                    ->with('large', $photo->imagePreset('large'))
                    ->with('meta', trans('content.photo.meta', [
                        'title' => $photo->vars()->title,
                        'username' => $photo->user->vars()->name,
                        'created_at' => $photo->vars()->created_at,
                    ]));
        });
        /*
        if ($content->count() < 9) {
            $content = $content->merge(array_fill(
                    0,
                    9 - $content->count(),
                    component('PhotoCard')->with('small', '/v2/svg/image_none.svg')
            ));
        }
        */
        return component('PhotoRow')
            ->with('content', $content)
            ->with('button', $button);
    }
}