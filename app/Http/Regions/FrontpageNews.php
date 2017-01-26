<?php

namespace App\Http\Regions;

class FrontpageNews
{
    public function render($news)
    {
        return collect()
            ->push(component('BlockTitle')
                ->with('title', trans('frontpage.index.news.title'))
                ->with('route', route('news.index'))
            )
            ->push(component('Grid3')
                ->with('gutter', true)
                ->with('items', $news->map(function ($new) {
                    return region('NewsCard', $new);
                }))
            );
    }
}
