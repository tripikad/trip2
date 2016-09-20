<?php

namespace App\Http\Regions;

class FrontpageNews
{

    public function render($news)
    {

        return component('Block')
            ->is('white')
            ->is('uppercase')
            ->with('title', trans('frontpage.index.news.title'))
            ->with('content', collect()->push(component('Grid3')
                ->with('gutter', true)
                ->with('items', $news->map(function ($new) {
                    return region('NewsCard', $new);
                }))
            ));
    
    }

}
