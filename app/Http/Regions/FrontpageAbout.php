<?php

namespace App\Http\Regions;

class FrontpageAbout
{
    public function render()
    {
        return component('GridSplit')
            ->with('left_content', collect()
                ->push(component('Body')
                    ->is('responsive')
                    ->with('body', trans('frontpage.index.about'))
                    ->with('content', collect()
                        ->push(component('Link')
                            ->with('title', trans('content.action.more.about'))
                            ->with('route', route('static.show', [1534]))
                        )
                    )
                )
            )
            ->with('right_content', collect()
                ->push(component('Button')
                    ->with('title', trans('frontpage.index.about.register'))
                    ->with('route', route('register.form'))
                )
            );
    }
}
