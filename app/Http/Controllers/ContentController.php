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

        return \View::make("pages.content.$type.index")
            ->with('title', config("content.types.$type.title"))
            ->with('contents', $contents)
            ->render();
    
    }


    public function show($id)
    {
        $content = \App\Content::with('user', 'comments', 'comments.user', 'flags', 'comments.flags', 'flags.user', 'comments.flags.user', 'destinations', 'topics', 'carriers')
            ->findorFail($id);
     
        return \View::make("pages.content.show")
            ->with('title', config("content.types.$content->type.title"))
            ->with('content', $content)
            ->render();
    }

    public function create($type)
    {

        return \View::make("pages.content.edit")
            ->with('title', config("content.types.$type.edit.title"))
            ->with('fields', config("content.types.$type.edit.fields"))
            ->with('url', 'content/' . $type)
            ->render();

    }

    public function store(Request $request, $type)
    {
        $fields = ['user_id' => $request->user()->id, 'type' => $type];

        \App\Content::create(array_merge($request->all(), $fields));

        return redirect('content/index/' . $type );

    }

    public function edit($id)
    {

        $content = \App\Content::findorFail($id);

        return \View::make("pages.content.edit")
            ->with('title', config("content.types.$content->type.edit.title"))
            ->with('fields', config("content.types.$content->type.edit.fields"))
            ->with('content', $content)
            ->with('method', 'put')
            ->with('url', 'content/' . $id)
            ->render();

    }

    public function update(Request $request, $id)
    {
  
        $content = \App\Content::findorFail($id);

        $fields = ['user_id' => $request->user()->id];

        $content->update(array_merge($request->all(), $fields));

        return redirect('content/' . $id );

    }

}
