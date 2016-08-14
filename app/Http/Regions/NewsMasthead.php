<?php

namespace App\Http\Regions;

class NewsMasthead
{
    public function render($post)
    {
        $user = auth()->user();

        return component('NewsMasthead')
            ->with('title', $post->title)
            ->with('background', $post->getHeadImage())
            ->with('header', component('Header')
                ->with('search', component('HeaderSearch')->is('white'))
                ->with('logo', component('Icon')
                    ->with('icon', 'tripee_logo_plain_dark')
                    ->with('width', 80)
                    ->with('height', 30)
                )
                ->with('navbar', region('Navbar', 'white'))
                ->with('navbar_mobile', region('NavbarMobile', 'white'))
            )
            ->with('meta', component('Meta')
                ->with('items', collect()
                    ->push(component('ProfileImage')
                        ->with('route', route('user.show', [$post->user]))
                        ->with('image', $post->user->imagePreset('small_square'))
                        ->with('rank', $post->user->vars()->rank)
                    )
                    ->push(component('Link')
                        ->with('title', $post->user->vars()->name)
                        ->with('route', route('user.show', [$post->user]))
                    )
                    ->push(component('Link')
                        ->with('title', $post->vars()->created_at)
                    )
                    ->merge($post->destinations->map(function ($tag) {
                        return component('Tag')->is('orange')->with('title', $tag->name);
                    }))
                    ->merge($post->topics->map(function ($tag) {
                        return component('Tag')->with('title', $tag->name);
                    }))
                    ->pushWhen($user && $user->hasRole('admin'), component('Link')
                        ->with('title', trans('content.action.edit.title'))
                        ->with('route', route('content.edit', [$post->type, $post]))
                    )
                    ->pushWhen($user && $user->hasRole('admin'), component('Form')
                            ->with('route', route('content.status', [
                                $post->type,
                                $post,
                                (1 - $post->status),
                            ]))
                            ->with('method', 'PUT')
                            ->with('fields', collect()
                                ->push(component('FormLink')
                                    ->with('title', trans("content.action.status.$post->status.title"))
                                )
                            )
                    )
                )
            );
    }
}
