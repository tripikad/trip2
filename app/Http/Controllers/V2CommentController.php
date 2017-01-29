<?php

namespace App\Http\Controllers;

use App\Comment;

class V2CommentController extends Controller
{
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        return layout('1col')

            ->with('header', region('StaticHeader', collect()
                ->push(component('Title')
                    ->with('title', trans('comment.edit.title'))
                )
            ))

            ->with('content', collect()
                ->push(component('Form')
                    ->with('route', route('comment.update', [$comment]))
                    ->with('fields', collect()
                        ->push(component('FormTextarea')
                            ->with('title', trans('comment.edit.body.title'))
                            ->with('name', 'body')
                            ->with('value', old('body', $comment->body))
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('comment.edit.submit.title'))
                        )
                    )
                )
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }
}
