<?php

namespace App;

use Exception;
use Cache;

class V2ContentVars
{
    protected $content;

    public function __construct(Content $content)
    {
        $this->content = $content;
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
        return $this->content->title;
    }

    public function shortTitle()
    {
        return str_limit($this->content->title, 60);
    }

    public function body()
    {
        return format_body($this->content->body);
    }

    public function created_at()
    {
        return format_date($this->content->created_at);
    }

    public function updated_at()
    {
        return format_date($this->content->created_at);
    }

    public static function IsNew($content)
    {
        if (auth()->check()) {
            $userId = auth()->id();

            $key = 'new_'.$content->id.'_'.$userId;

                // If the post is unread by the user or there are new comments

                if (Cache::has($key)) {
                    $content->isNew = true;
                }

            if ($newId = Cache::get($key)) {
                $content->NewCommentId = $newId;

                    //New comment counter if needed
                    /*
                    $content->NewCommentCount = $content->comments->filter(function ($comment) use ($content) {
                       return  $comment->id >= $content->NewCommentId;
                   })->count();
                   */
            }

            return $content;
        }

        return $content;
    }
}
