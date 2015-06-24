<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ContentController extends Controller
{

    public function index($type)
    {
       
        $contents = \App\Content::whereType($type)
            ->with(config("content.types.$type.with"))
            ->latest()
            ->simplePaginate(25);
    
        return \View::make("content.$type.index")
            ->with('title', config("content.types.$type.title"))
            ->with('contents', $contents)
            ->render();
    
    }


    public function show($id)
    {
        $content = \App\Content::with('user', 'comments', 'comments.user', 'flags', 'comments.flags', 'flags.user', 'comments.flags.user')
            ->findorFail($id);
     
        return \View::make("content.$content->type.show", compact('content'))->render();
    }


}
