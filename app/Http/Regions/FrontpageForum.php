<?php

namespace App\Http\Regions;

class FrontpageForum
{
    public function render($forums)
    {
        return component('Block')
            ->is('uppercase')
            ->is('white')
            ->with('title', trans('frontpage.index.forum.title'))
            ->with('content', collect()
                ->push(component('GridSplit')
                    ->with('left_col', 8)
                    ->with('right_col', 3)
                    ->with('left_content', collect()
                        ->merge($forums->take($forums->count() / 2)->map(function ($forum) {
                            return region('ForumRow', $forum);
                        }))
                        ->push(component('Promo')->with('promo', 'body'))
                        ->merge($forums->slice($forums->count() / 2)->map(function ($forum) {
                            return region('ForumRow', $forum);
                        }))
                    )
                    ->with('right_content', collect()
                        ->merge(region('ForumLinks'))
                        ->push(region('ForumAbout', 'white'))
                        ->push(component('Promo')->with('promo', 'sidebar_small'))
                        ->push(component('Promo')->with('promo', 'sidebar_large'))
                    )
                ));
    }
}
