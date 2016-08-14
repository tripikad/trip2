<?php

namespace App;

use App\Content;

class ContentVars
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

    public function body()
    {
        return format_body($this->content->body);
    }

}
