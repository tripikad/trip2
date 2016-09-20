<?php

namespace App\Http\Regions;

class ForumBottom
{

    public function render($forums)
    {

        return component('Block')
            ->is('red')
            ->is('uppercase')
            ->is('white')
            ->with('title', trans('frontpage.index.forum.title'))
            ->with('content', collect()
                ->push(component('GridSplit')
                    ->with('left_col', 3)
                    ->with('right_col', 9)
                    ->with('left_content', collect()->merge(region('ForumLinks')))
                    ->with('right_content', $forums->map(function ($forum) {
                        return region('ForumRow', $forum);
                    }))
                )
            );
    
    }

}
