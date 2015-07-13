<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    protected $rules = [
        'body' => 'required'
    ];

    public function store(Request $request, $type, $id)
    {

        $this->validate($request, $this->rules);

        $fields = ['user_id' => $request->user()->id, 'content_id' => $id];

        $comment = \App\Comment::create(array_merge($request->all(), $fields));
        
        return redirect()->route('content.show', [$type, $id, '#comment-' . $comment->id]);

    }

    public function edit($id)
    {

        $comment = \App\Comment::findorFail($id);

        return \View::make("pages.comment.edit")
            ->with('comment', $comment)
            ->render();

    }

    public function update(Request $request, $id)
    {

        $this->validate($request, $this->rules);

        $comment = \App\Comment::findorFail($id);

        $fields = [];

        $comment->update(array_merge($request->all(), $fields));

        return redirect()->route('content.show', [$comment->content->type, $comment->content, '#comment-' . $comment->id]);

    }

}
