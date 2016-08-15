<?php

namespace App\Http\Regions;

class FlightRow {

    public function render($post)
    {

        return component('Body')
            ->with('body', $post->body);

    }

}
