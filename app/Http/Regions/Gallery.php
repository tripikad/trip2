<?php

namespace App\Http\Regions;

class Gallery {

    public function render($images)
    {
        return component('Gallery')->with('images', $images->map(function($image) {
            return collect()
                ->put('id', $image->id)
                ->put('small', $image->imagePreset('small_square'))
                ->put('large', $image->imagePreset('large'))
                ->put('meta', component('Meta')->with('items', collect()
                    ->push(component('MetaLink')
                        ->with('title', $image->vars()->title)
                    )
                    ->push(component('MetaLink')
                        ->with('title', $image->vars()->created_at)
                    )
                    ->push(component('MetaLink')
                        ->with('title', $image->user->vars()->name)
                        ->with('route', route('user.show', [$image->user]))
                    )
                    )->render()
                );
        }))->render();
    
    }

}
