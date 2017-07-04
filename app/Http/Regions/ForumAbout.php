<?php

namespace App\Http\Regions;

class ForumAbout
{
    public function render($type = 'forum')
    {
        $user = auth()->user();

        $route = $type == 'misc' ? 'forum.create.misc' : 'forum.create';
        $title = $type == 'misc' ? 'content.misc.index.title' : 'frontpage.index.forum.title';

        return component('Block')
            ->with('title', trans($title))
            ->with('content', collect()
                ->push(component('Body')
                    ->with('body', trans("site.description.$type"))
                )
                ->pushWhen($user && $user->hasRole('regular'), component('Button')
                    ->with('title', trans("content.$type.create.title"))
                    ->with('route', route($route))
                )
            );
    }
}
