<?php

namespace App\Http\Regions;

class BlogRow
{

    public function render($post)
    {

        return component('Body')
            ->with('body', $post->body);

    }

}
