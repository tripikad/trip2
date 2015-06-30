<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContentController extends Controller
{

    public function index(Request $request, $type)
    {
       
        $contents = \App\Content::whereType($type)
            ->with(config("content.types.$type.with"))
            ->latest(config("content.types.$type.latest"));
    
        if ($request->destination) {
            $contents = $contents
                ->join('content_destination', 'content_destination.content_id', '=', 'contents.id')
                ->where('content_destination.destination_id', '=', $request->destination);
        }   

        if ($request->topic) {
            $contents = $contents
                ->join('content_topic', 'content_topic.content_id', '=', 'contents.id')
                ->where('content_topic.topic_id', '=', $request->topic);
        } 

        $contents = $contents->simplePaginate(config("content.types.$type.paginate"));

        return \View::make("content.$type.index")
            ->with('title', config("content.types.$type.title"))
            ->with('contents', $contents)
            ->render();
    
    }


    public function show($id)
    {
        $content = \App\Content::with('user', 'comments', 'comments.user', 'flags', 'comments.flags', 'flags.user', 'comments.flags.user', 'destinations', 'topics', 'carriers')
            ->findorFail($id);
     
        return \View::make("content.show", compact('content'))->render();
    }


}
