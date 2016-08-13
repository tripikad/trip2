<?php

namespace App\Http\Regions;

class MastheadNews {

    public function render($news)
    {

        return component('MastheadNews')
            ->with('title', $news->title)
            ->with('background', $news->getHeadImage())
            ->with('header', component('Header')
                ->with('search', component('HeaderSearch')->is('white'))
                ->with('logo', component('Icon')
                    ->with('icon', 'tripee_logo_plain_dark')
                    ->with('width', 80)
                    ->with('height', 30)
                )
                ->with('navbar', region('HeaderNavbar', 'white'))
                ->with('navbar_mobile', region('HeaderNavbarMobile', 'white'))
            )
            ->with('meta', component('Meta')
                ->with('items', collect()
                    ->push(component('Link')
                        ->with('title', $news->user->name)
                        ->with('route', route('user.show', [$news->user]))
                    )
                    ->push(component('Link')
                        ->with('title', $news->created_at->diffForHumans())
                    )
                )
            );
    }

}
