<?php

namespace App\Http\Regions;

class ForumPost
{
    public function render($post)
    {
        $user = auth()->user();

        $followStatus = $user && $user->follows()->where([
            'followable_id' => $post->id,
            'followable_type' => 'App\Content',
        ])->first() ? 0 : 1;

        dump($post->flags->where('flag_type', 'good')->count());

        return component('ForumPost')
            ->is($post->status ?: 'unpublished')
            ->with('title', $post->vars()->title)
            ->with('user', component('UserImage')
                ->with('size', 64)
                ->with('border', 4)
                ->with('route', route('user.show', [$post->user]))
                ->with('image', $post->user->imagePreset('small_square'))
                ->with('rank', $post->user->vars()->rank)
            )
            ->with('meta', component('Meta')->with('items', collect()
                    ->push(component('MetaLink')
                        ->with('title', $post->user->vars()->name)
                        ->with('route', route('user.show', [$post->user]))
                    )
                    ->push(component('MetaLink')
                        ->with('title', $post->vars()->created_at)
                    )
                    ->pushWhen($user && $user->hasRoleOrOwner('admin', $post->user->id),
                        component('MetaLink')
                            ->with('title', trans('content.action.edit.title'))
                            ->with('route', route('content.edit', [$post->type, $post]))
                    )
                    ->pushWhen($user && $user->hasRole('admin'), component('Form')
                            ->with('route', route(
                                'content.status',
                                [$post->type, $post, (1 - $post->status)]
                            ))
                            ->with('method', 'PUT')
                            ->with('fields', collect()
                                ->push(component('FormLink')
                                    ->with(
                                        'title',
                                        trans("content.action.status.$post->status.title")
                                    )
                                )
                            )
                    )
/*
            <a href="{{ route('flag.toggle', [
                $flags['good']['flaggable_type'],
                $flags['good']['flaggable_id'],
                $flags['good']['flag_type'],
                isset($flags['good']['return']) ? $flags['good']['return'] : null,
            ]) }}" class="c-flag__item-link {{ isset($flags['good']['active']) && $flags['good']['active'] ? 'm-active' : '' }} js-flag">
*/
                    ->push(component('Flag')
                        ->with('route', route(
                            'flag.toggle',
                            ['content', $post, 'good']
                        ))
                        ->with('value', $post->flags->where('flag_type', 'good')->count())
                        ->with('icon', 'icon-thumb-up')
                    )
                    ->push(component('Flag')
                        ->with('value', 1)
                        ->with('route', route('styleguide.flag'))
                        ->with('icon', 'icon-thumb-down')
                    )
                    ->pushWhen($user, component('Form')
                            ->with('route', route(
                                'follow.follow.content',
                                [$post->type, $post, $followStatus]
                            ))
                            ->with('method', 'PUT')
                            ->with('fields', collect()
                                ->push(component('FormLink')
                                    ->with(
                                        'title',
                                        trans("content.action.follow.$followStatus.title")
                                    )
                                )
                            )
                    )
                )
            )
            ->with('body', component('Body')
                ->is('responsive')
                ->with('body', $post->vars()->body)
            );
    }
}
