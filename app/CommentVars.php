<?php

namespace App;

use Exception;
use Illuminate\Support\Str;

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

        $message = '%s does not respond to the "%s" property or method.';

        throw new Exception(sprintf($message, static::class, $property));
    }

    public function title()
    {
        return Str::limit(strip_tags($this->comment->body), 30);
    }

    public function body()
    {
        //return format_body($this->comment->body);
        return format_comment(strip_tags($this->comment->body));
    }

    public function edit_body()
    {
        return format_comment_edit(strip_tags($this->comment->body));
    }

    public function created_at()
    {
        return format_date($this->comment->created_at);
    }

    public function updated_at()
    {
        return format_date($this->comment->created_at);
    }

    public function flagCount($flagType)
    {
        return $this->comment->flags->where('flag_type', $flagType)->count();
    }
}
