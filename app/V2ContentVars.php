<?php

namespace App;

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
    }

    public function title()
    {
        return $this->content->title;
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
}
