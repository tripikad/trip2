<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(Request $request, $id)
    {

        $fields = ['user_id' => $request->user()->id, 'content_id' => $id];

        $comment = \App\Comment::create(array_merge($request->all(), $fields));
        
        return redirect('content/' . $id . '#comment-' . $comment->id);

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
  
        $comment = \App\Comment::findorFail($id);

        $fields = [];

        $comment->update(array_merge($request->all(), $fields));

        return redirect('content/' . $comment->content->id . '#comment-' . $comment->id);

    }

}
