<?php

namespace App\Http\Regions;

class ForumLinks
{
    public function render()
    {
        return collect()
            ->push(component('Link')
                ->is('large')
                ->with('title', trans('frontpage.index.forum.general'))
                ->with('route', route('forum.index'))
            )
            ->push(component('Link')
                ->is('large')
                ->with('title', trans('frontpage.index.forum.buysell'))
                ->with('route', route('forum.index'))
            )
            ->push(component('Link')
                ->is('large')
                ->with('title', trans('frontpage.index.forum.expat'))
                ->with('route', route('forum.index'))
            );
    }
}
