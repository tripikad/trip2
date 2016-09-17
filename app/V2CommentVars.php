<?php

namespace App;

use Exception;
use Cache;

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
        if (auth()->check()) {

            $userId = auth()->id();

            $key = 'new_'.$this->comment->id.'_'.$userId;
            
                // If the post is unread by the user or there are new comments

                if (Cache::has($key)) {

                    // Mark post as new so the view can style the post accordingly

                    return true;
                }

            return false;
        }

        return false;
    }
}
