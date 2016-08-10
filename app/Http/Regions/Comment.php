<?php

/*

        if (auth()->user() && auth()->user()->hasRoleOrOwner('admin', $this->user->id)) {
            $actions['edit'] = [
               'title' => trans('comment.action.edit.title'),
               'route' => route('comment.edit', [$this]),
           ];
        }

        if (auth()->user() && auth()->user()->hasRole('admin')) {
            $actions['status'] = [
               'title' => trans("comment.action.status.$this->status.title"),
               'route' => route('comment.status', [$this, (1 - $this->status)]),
               'method' => 'PUT',
           ];
        }
        
        {!! Form::open([
            'url' => $action['route'],
            'method' => isset($action['method']) ? $action['method'] : 'GET',
            'class' => 'c-actions__form m-inline'
        ]) !!}

        {!! Form::submit($action['title'], [
            'class' => 'c-actions__link'
        ]) !!}

        {!! Form::close() !!}

*/

namespace App\Http\Regions;

use Illuminate\Http\Request;

class Comment
{
    public function render(Request $request, $comment)
    {
        return component('Comment')
            ->is('unpublished')
            ->with('profile', component('ProfileImage')
                ->with('route', route('user.show', [$comment->user]))
                ->with('image', $comment->user->imagePreset('small_square'))
                ->with('rank', $comment->user->rank * 90)
            )
            ->with('meta', collect()
                ->push(component('LinkMeta')
                    ->with('title', $comment->user->name)
                    ->with('route', route('user.show', [$comment->user]))
                )
                ->push(component('LinkMeta')
                    ->with('title', $comment->created_at->diffForHumans())
                    ->with('route', route('content.show', [
                        $comment->content->type, $comment->content, '#comment-'.$comment->id,
                    ]))
                )
                ->push(component('Flag')
                    ->with('value', 1)
                    ->with('route', route('styleguide.flag'))
                    ->with('icon', 'icon-thumb-up')
                )
            )
            ->with('body', component('Body')->with('body', $comment->body));
    }
}
