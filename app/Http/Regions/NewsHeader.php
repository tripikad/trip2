<?php

namespace App\Http\Regions;

class NewsHeader
{
    public function render($new)
    {
        $user = auth()->user();

        return component('NewsHeader')
            ->with('title', $new->vars()->title)
            ->with('background', $new->getHeadImage())
            ->with(
                'navbar',
                component('Navbar')
                    ->is('white')
                    ->with('search', component('NavbarSearch')->is('white'))
                    ->with(
                        'logo',
                        component('Icon')
                            ->with('icon', 'trip-ukraine')
                            ->with('width', 200)
                            ->with('height', 150)
                    )
                    ->with('navbar_desktop', region('NavbarDesktop', 'white'))
                    ->with('navbar_mobile', region('NavbarMobile', 'white'))
            )
            ->with(
                'meta',
                component('Meta')->with(
                    'items',
                    collect()
                        ->push(
                            component('UserImage')
                                ->with('route', route('user.show', [$new->user]))
                                ->with('image', $new->user->imagePreset('xsmall_square'))
                                ->with('rank', $new->user->vars()->rank)
                        )
                        ->push(
                            component('MetaLink')
                                ->is('white')
                                ->with('title', $new->user->vars()->name)
                                ->with('route', route('user.show', [$new->user]))
                        )
                        ->push(
                            component('MetaLink')
                                ->is('white')
                                ->with('title', $new->vars()->created_at)
                        )
                        ->merge(
                            $new->destinations->map(function ($tag) {
                                return component('Tag')
                                    ->is('white')
                                    ->with('title', $tag->vars()->shortName)
                                    ->with('route', route('destination.showSlug', [$tag->slug]));
                            })
                        )
                        ->merge(
                            $new->topics->map(function ($tag) {
                                return component('MetaLink')
                                    ->is('white')
                                    ->with('title', $tag->vars()->shortName)
                                    ->with('route', route('news.index', ['topic' => $tag]));
                            })
                        )
                        ->pushWhen(
                            $user && $user->hasRole('admin'),
                            component('MetaLink')
                                ->is('green')
                                ->is('filled')
                                ->with('title', trans('content.action.edit.title'))
                                ->with('route', route('news.edit', [$new]))
                        )
                        ->pushWhen(
                            $user && $user->hasRole('admin'),
                            component('Form')
                                ->with('route', route('content.status', [$new->type, $new, 1 - $new->status]))
                                ->with(
                                    'fields',
                                    collect()->push(
                                        component('FormLink')
                                            ->is('pink')
                                            ->is('filled')
                                            ->with('title', trans("content.action.status.$new->status.title"))
                                    )
                                )
                        )
                )
            );
    }
}
