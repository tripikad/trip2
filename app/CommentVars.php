<?php

namespace App;

use App\Comment;

class CommentVars
{
    
    protected $comment;
   
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return call_user_func([$this, $property]);
        }
    }

    public function body()
    {
        return format_body($this->comment->body);
    }

}
