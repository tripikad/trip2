<?php

namespace App\Http\Regions;

class CompanyRow
{

    public function render($post)
    {

        return component('Body')
            ->with('body', $post->body);

    }

}
