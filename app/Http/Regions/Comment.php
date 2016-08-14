<?php

namespace App\Http\Regions;

class Comment
{
    public function render($comment)
    {
        $user = auth()->user();

        return component('Comment')
            ->show($comment->status || ($user && $user->hasRole('admin')))
            ->is($comment->status ?: 'unpublished')
            ->with('profile', component('ProfileImage')
                ->with('route', route('user.show', [$comment->user]))
                ->with('image', $comment->user->imagePreset('small_square'))
                ->with('rank', $comment->user->vars()->rank)
            )
            ->with('meta', component('Meta')->with('items', collect()
                    ->push(component('Link')
                        ->with('title', $comment->user->vars()->name)
                        ->with('route', route('user.show', [$comment->user]))
                    )
                    ->push(component('Link')
                        ->with('title', $comment->created_at->diffForHumans())
                        ->with('route', route('content.show', [
                            $comment->content->type, $comment->content, '#comment-'.$comment->id,
                        ]))
                    )
                    ->pushWhen($user && $user->hasRoleOrOwner('admin', $comment->user->id), component('Link')
                        ->with('title', trans('comment.action.edit.title'))
                        ->with('route', route('comment.edit', [$comment]))
                    )
                    ->pushWhen($user && $user->hasRole('admin'), component('Form')
                            ->with('route', route('comment.status', [$comment, (1 - $comment->status)]))
                            ->with('method', 'PUT')
                            ->with('fields', collect()
                                ->push(component('FormLink')
                                    ->with('title', trans("comment.action.status.$comment->status.title"))
                                )
                            )
                    )
                    ->push(component('Flag')
                        ->with('value', 1)
                        ->with('route', route('styleguide.flag'))
                        ->with('icon', 'icon-thumb-up')
                    )
                )
            )
            ->with('body', component('Body')
                ->with('body', $comment->vars()->body)
            );
    }
}
