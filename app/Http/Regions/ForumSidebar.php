<?php

namespace App\Http\Regions;

class ForumSidebar
{
    public function render($posts)
    {
        return component('Block')
            ->is('uppercase')
            ->with('title', 'Tripikad räägivad')
            ->with('content', $posts->map(function ($post) {
                return region('ForumRowSmall', $post);
            })
            );
    }
}
