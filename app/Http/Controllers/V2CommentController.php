<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use App\Comment;
use Illuminate\Http\Request;

class V2CommentController extends Controller
{
    protected $rules = [
        'body' => 'required',
    ];

    public function store(Request $request, $type, $content_id)
    {
        $this->validate($request, $this->rules);

        $fields = [
            'content_id' => $content_id,
            'status' => 1,
        ];

        $comment = Auth::user()->comments()->create(array_merge($request->all(), $fields));

        Log::info('New comment added', [
            'user' =>  Auth::user()->name,
            'body' =>  $request->get('body'),
            'link' => route('content.show', [$type, $content_id, '#comment-'.$comment->id]),
            'followers' => $comment
                ->content
                ->followersEmails()
                ->forget(Auth::user()->id)
                ->count(),
        ]);

        $content = $comment->content;

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

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        $comment = \App\Comment::findorFail($id);

        $fields = [
            'status' => 1,
        ];

        $comment->update(array_merge($request->all(), $fields), ['touch' => false]);

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
