<?php

namespace App\Http\Regions;

class ForumSidebar
{
    public function render($forums)
    {
        return component('Block')
            ->is('uppercase')
            ->with('title', trans('destination.show.forum.title'))
            ->with('content', $forums->map(function ($forum) {
                return region('ForumRowSmall', $forum);
            })
        );
    }
}
