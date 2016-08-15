<?php

namespace App\Http\Controllers;

use App\Content;

class V2FlightController extends Controller
{
    public function index()
    {
        $type = 'flight';

        $posts = Content::whereType($type)->latest()->whereStatus(1)->take(20)->get();

        return view('v2.layouts.2col')
            ->with('header', region('Masthead', trans("content.$type.index.title")))
            ->with('content', collect()
                ->merge($posts->map(function ($post) {
                    return region('FlightRow', $post);
                }))
            );
    }

    public function edit($id)
    {
        $post = Content::whereType('flight')
           ->whereStatus(1)
           ->findOrFail($id);

        return view('v2.layouts.fullpage')
            ->with('content', collect()
                ->push(component('Editor')->with('post', $post))
            );
    }
}
