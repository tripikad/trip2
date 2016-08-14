<?php

namespace App;

class V2CommentVars
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

    public function title()
    {
        return str_limit($this->attributes['body'], 30);
    }

    public function body()
    {
        return format_body($this->comment->body);
    }

    public function created_at()
    {
        return format_date($this->comment->created_at);
    }

    public function updated_at()
    {
        return format_date($this->comment->created_at);
    }
}
