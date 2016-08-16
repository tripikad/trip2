<?php

namespace App\Http\Regions;

class ForumAbout {

    public function render()
    {
        $type = 'forum';
        
        return component('Block')
            ->with('content', collect()
                ->push(component('Body')
                    ->with('body', trans("site.description.$type"))
                )
                ->push(component('Button')
                    ->with('title', trans("content.$type.create.title"))
                    ->with('route', route('content.create', [$type]))
                )
            )
        ;
    }

}
