<?php

namespace App\Http\Regions;

class NewsCard
{
    public function render($post)
    {
        return component('NewsCard')
            ->with('route', route('v2.news.show', [$post->slug]))
            ->with('image', $post->imagePreset('small'))
            ->with('title', $post->vars()->shortTitle)
            ->with('meta', component('Meta')
                ->with('items', collect()
                    ->push(component('MetaLink')
                        ->with('title', $post->vars()->created_at)
                    )
                    ->push(component('MetaLink')
                        ->with('title', 'Edit')
                        ->with('route', route('v2.news.edit', [$post]))
                    )
                )
            );
    }
}
