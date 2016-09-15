<?php

namespace App\Http\Regions;

class FrontpageGallery {

    public function prepareImages($images)
    {
        return $images->map(function($image) {
        
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
        });
    
    }

    public function render($images)
    {

        return component('Block')
            ->is('red')
            ->is('uppercase')
            ->is('white')
            ->with('title', trans('frontpage.index.photo.title'))
            ->with('content', collect()
                ->push(component('Gallery')
                    ->with('images', $this->prepareImages($images))
                )
            );

    }

}
