<?php

namespace App;

use Cache;
use Exception;

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

    public function commentCount()
    {
        return count($this->content->comments);
    }

    private function getUnreadCache()
    {
        if ($user = request()->user()) {
            $key = 'new_'.$this->content->id.'_'.$user->id;

            return Cache::get($key);
        }

        return false;
    }

    public function isNew()
    {
        $cache = $this->getUnreadCache();

        if ($cache > 0) {
            return false;
        }
        if ($cache == '0') {
            return true;
        }

        return false;
    }

    public function firstUnreadCommentId()
    {
        $cache = $this->getUnreadCache();

        if ($cache > 0) {
            return $cache;
        }

        return false;
    }

    public function unreadCommentCount()
    {
        if ($this->firstUnreadCommentId() > 0) {
            return $this->content->comments->filter(function ($comment) {
                return  $comment->id >= $this->firstUnreadCommentId();
            })
            ->count();
        }

        return false;
    }
}
