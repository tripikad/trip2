<?php

namespace App\Http\Regions;

class ForumLinks
{
    public function render($user = false)
    {
        $user = auth()->user();

        return collect()
            ->push(component('Link')
                ->is('large')
                ->with('title', trans('frontpage.index.forum.general'))
                ->with('route', route('v2.forum.index'))
            )
            ->push(component('Link')
                ->is('large')
                ->with('title', trans('frontpage.index.forum.buysell'))
                ->with('route', route('v2.buysell.index'))
            )
            ->push(component('Link')
                ->is('large')
                ->with('title', trans('frontpage.index.forum.expat'))
                ->with('route', route('v2.expat.index'))
            )
            ->pushWhen($user, component('Link')
                ->is('large')
                ->with('title', trans('menu.user.follow'))
                ->with('route', route('v2.follow.index', [$user]))
            );
    }
}
