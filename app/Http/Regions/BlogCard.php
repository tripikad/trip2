<?php

namespace App\Http\Regions;

class BlogCard {

    public function render($post)
    {

        return component('Body')
            ->with('body', $post->body);

    }

}
