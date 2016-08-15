<?php

namespace App\Http\Regions;

class NewsRow
{
    public function render($post)
    {
        return component('Meta')->with('items', collect()
            ->push(component('Link')
                ->with('title', $post->title)
                ->with('route', route('news.show', [$post]))
            )
            ->push(component('Link')
                ->with('title', 'Edit')
                ->with('route', route('news.edit', [$post]))
            )
        );
    }
}
