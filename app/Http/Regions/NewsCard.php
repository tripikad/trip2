<?php

namespace App\Http\Regions;

class NewsCard
{
    public function render($post)
    {
        return component('NewsCard')
            ->with('route', route('news.show', [$post]))
            ->with('background', $post->imagePreset('small'))
            ->with('title', $post->vars()->title)
            ->with('meta', component('Meta')
                ->with('items', collect()
                    ->push(component('Link')
                        ->with('title', $post->vars()->created_at)
                    )
                    ->push(component('Link')
                        ->with('title', 'Edit')
                        ->with('route', route('news.edit', [$post]))
                    )
                )
            );
    }
}
