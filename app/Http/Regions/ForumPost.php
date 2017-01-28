<?php

namespace App\Http\Regions;

class ForumPost
{
    public function render($post, $editRoute = 'forum.edit')
    {
        $user = auth()->user();

        $followStatus = $user && $user->follows()->where([
            'followable_id' => $post->id,
            'followable_type' => 'App\Content',
        ])->first() ? 0 : 1;

        return component('ForumPost')
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
                    ->merge($post->destinations->map(function ($destination) {
                        return component('Tag')
                            ->is('orange')
                            ->with('title', $destination->name)
                            ->with('route', route('destination.show', [$destination]));
                    }))
                    ->merge($post->topics->map(function ($topic) {
                        return component('MetaLink')
                            ->with('title', $topic->name)
                            ->with('route', route('forum.index', ['topic' => $topic]));
                    }))
                    ->pushWhen($user && $user->hasRoleOrOwner('admin', $post->user->id),
                        component('MetaLink')
                            ->with('title', trans('content.action.edit.title'))
                            ->with('route', route($editRoute, [$post]))
                    )
                    ->pushWhen($user && $user->hasRole('admin'), component('Form')
                            ->with('route', route(
                                'content.status',
                                [$post->type, $post, (1 - $post->status)]
                            ))
                            ->with('fields', collect()
                                ->push(component('FormLink')
                                    ->with(
                                        'title',
                                        trans("content.action.status.$post->status.title")
                                    )
                                )
                            )
                    )
                    ->push(component('Flag')
                        ->is('green')
                        ->with('route', route(
                            'flag.toggle',
                            ['content', $post, 'good']
                        ))
                        ->with('value', $post->vars()->flagCount('good'))
                        ->with('flagged', $user
                            ? $user->vars()->hasFlaggedContent($post, 'good')
                            : false
                        )
                        ->with('icon', 'icon-thumb-up')
                        ->with('flagtitle', trans('flag.content.good.flag.title'))
                        ->with('unflagtitle', trans('flag.content.good.unflag.title'))
                    )
                    ->push(component('Flag')
                        ->is('red')
                        ->with('route', route(
                            'flag.toggle',
                            ['content', $post, 'bad']
                        ))
                        ->with('value', $post->vars()->flagCount('bad'))
                        ->with('flagged', $user
                            ? $user->vars()->hasFlaggedContent($post, 'bad')
                            : false
                        )
                        ->with('icon', 'icon-thumb-up')
                        ->with('flagtitle', trans('flag.content.bad.flag.title'))
                        ->with('unflagtitle', trans('flag.content.bad.unflag.title'))
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
