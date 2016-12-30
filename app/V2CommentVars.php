<?php

namespace App;

use Cache;
use Exception;

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

        $message = '%s does not respond to the "%s" property or method.';

        throw new Exception(
            sprintf($message, static::class, $property)
        );
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

    public function isNew()
    {
        return $this->comment->id >= $this->comment->parent->vars()->firstUnreadCommentId();

        return false;
    }
}
