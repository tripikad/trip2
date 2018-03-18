<?php

namespace App\Utils;

class Layout
{
    protected $name;
    protected $with;
    protected $cached;

    public function __construct($layout)
    {
        $this->layout = $layout;
        $this->with = collect();
        $this->cached = true;
        $this->name = null;
    }

    public function with($key, $value)
    {
        $this->with->put($key, $value);

        return $this;
    }

    public function cached($condition)
    {
        $this->cached = $condition;

        return $this;
    }

    public function setLayoutName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function render()
    {
        $layoutName = $this->name ? $this->name : "layouts.$this->layout.$this->layout";
        $response = response()->view($layoutName, $this->with);

        return $this->cached
            ? $response->header(
                'Cache-Control',
                'public, s-maxage='.config('cache.headers.default')
            )
            : $response;
    }
}
