<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use App\Comment;
use Illuminate\Http\Request;

class V2CommentController extends Controller
{

    public function store($type, $content_id)
    {
        $rules = [
            'body' => 'required'
        ];

        $this->validate(request(), $rules);

        $comment = Auth::user()->comments()->create([
            'body' => request()->body,
            'content_id' => $content_id,
            'status' => 1
        ]);

        Log::info('New comment added', [
            'user' =>  $comment->user->name,
            'body' =>  $comment->body,
            'link' => route('content.show', [
                $type,
                $comment->content->id,
                '#comment-'.$comment->id
            ])
        ]);

        return backToAnchor('#comment-'.$comment->id)
            ->with('info', trans(
                'comment.created.title',
                ['title' => $comment->vars()->title()]
            ));
    }

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

    public function update($id)
    {
        $rules = [
            'body' => 'required'
        ];

        $this->validate(request(), $rules);

        $comment = Comment::findorFail($id);

        $comment->update(['body' => request()->body], ['touch' => false]);

        if ($comment->content->type == 'internal') {
            return redirect()
                ->route($comment->content->type.'.show', [
                    $comment->content,
                    '#comment-'.$comment->id,
                ]);
        }

        return redirect()
            ->route($comment->content->type.'.show', [
                $comment->content->slug,
                '#comment-'.$comment->id,
            ]);
    }

    public function status($id, $status)
    {
        $comment = \App\Comment::findorFail($id);

        if ($status == 0 || $status == 1) {
            $comment->status = $status;
            $comment->save(['touch' => false]);

            backToAnchor('#comment-'.$comment->id)
                ->with('info', trans("comment.action.status.$status.info", [
                    'title' => $comment->title,
                ]));
        }

        return back();
    }
}
