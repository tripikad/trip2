<?php

namespace App\Http\Regions;

class ForumAbout
{
    public function render($type = 'forum')
    {
        $user = auth()->user();

        return component('Block')
            ->with('content', collect()
                ->push(component('Body')
                    ->with('body', trans("site.description.$type"))
                )
                ->pushWhen($user && $user->hasRole('regular'), component('Button')
                    ->with('title', trans("content.$type.create.title"))
                    ->with('route', route("$type.create"))
                )
            );
    }
}
