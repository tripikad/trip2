<?php

namespace App\Http\Regions;

class MastheadNews {

    public function render($post)
    {

        return component('MastheadNews')
            ->with('title', $post->title)
            ->with('background', $post->getHeadImage())
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
                    ->push(component('ProfileImage')
                        ->with('route', route('user.show', [$post->user]))
                        ->with('image', $post->user->imagePreset('small_square'))
                        ->with('rank', $post->user->rank * 90)
                    )
                    ->push(component('Link')
                        ->with('title', $post->user->name)
                        ->with('route', route('user.show', [$post->user]))
                    )
                    ->push(component('Link')
                        ->with('title', $post->created_at->diffForHumans())
                    )
                    ->merge($post->destinations->map(function ($tag) {
                        return component('Tag')->is('orange')->with('title', $tag->name);
                    }))
                    ->merge($post->topics->map(function ($tag) {
                        return component('Tag')->with('title', $tag->name);
                    }))
                )
            );
    }

}
