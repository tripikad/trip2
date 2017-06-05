<?php

namespace App\Http\Regions;

class FrontpageShortnews
{
    public function render($news)
    {
        return collect()
            ->push(component('BlockTitle')
                ->with('title', trans('frontpage.index.shortnews.title'))
                ->with('route', route('shortnews.index'))
            )
            ->push(component('Grid4')
                ->with('gutter', true)
                ->with('items', $news->map(function ($new) {
                    return region('ShortnewsCard', $new);
                }))
            );
    }
}