<?php

namespace App\Http\Controllers;

use App\Content;

class V2ExperimentsBlogController extends Controller
{
    public function index()
    {
        return view('pages.blogtest.index', ['type' => 'blog']);
    }

    public function show()
    {
        $content = Content::where('type', 'blog')->latest()->first();

        return view('pages.blogtest.show', ['content' => $content, 'type' => 'blog']);
    }

    public function edit()
    {
        return view('pages.blogtest.edit')->with('topics', [])->with('topic', 0)->with('mode', 'edit')->with('url', 'url');
    }

    public function profile()
    {
        return view('pages.blogtest.profile');
    }
}
