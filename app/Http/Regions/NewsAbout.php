<?php

namespace App\Http\Regions;

class NewsAbout
{
    public function render()
    {
        $type = 'news';
        $user = auth()->user();

        return component('Block')
            ->with('content', collect()
                ->push(component('Body')
                    ->with('body', trans("site.description.$type"))
                )
                ->pushWhen($user && $user->hasRole('admin'), component('Button')
                    ->with('title', trans("content.$type.create.title"))
                    ->with('route', route('v2.news.create'))
                )
            );
    }
}
