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
                ->with('route', route('forum.index'))
            )
            ->push(component('Link')
                ->is('large')
                ->with('title', trans('frontpage.index.forum.buysell'))
                ->with('route', route('buysell.index'))
            )
            ->push(component('Link')
                ->is('large')
                ->with('title', trans('frontpage.index.forum.expat'))
                ->with('route', route('expat.index'))
            )
            ->push(component('Link')
                ->is('large')
                ->with('title', trans('frontpage.index.forum.misc'))
                ->with('route', route('misc.index'))
            )
            ->pushWhen($user, component('Link')
                ->is('large')
                ->with('title', trans('menu.user.follow'))
                ->with('route', route('follow.index', [$user]))
            )
            ->pushWhen($user && $user->hasRole('admin'), component('Link')
                ->is('large')
                ->with('title', trans('menu.auth.admin'))
                ->with('route', route('internal.index'))
            );
    }
}
