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
                    ->with('left_col', 3)
                    ->with('right_col', 8)
                    ->with('left_content', collect()
                        ->push(region('ForumAbout', 'white'))
                        ->merge(region('ForumLinks'))
                        ->push(component('Promo')->with('promo', 'sidebar_small'))
                        ->push(component('Promo')->with('promo', 'sidebar_large'))
                    )
                    ->with('right_content', $forums->map(function ($forum) {
                        return region('ForumRow', $forum);
                    }))
                ));
    }
}
