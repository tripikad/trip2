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
            ->with('contents', $contents)
            ->with('type', $type)
            ->render();
    
    }


    public function show($type, $id)
    {
        $content = \App\Content::with('user', 'comments', 'comments.user', 'flags', 'comments.flags', 'flags.user', 'comments.flags.user', 'destinations', 'topics', 'carriers')
            ->findorFail($id);
     
        return \View::make("pages.content.show")
            ->with('content', $content)
            ->with('type', $type)
            ->render();
    }

    public function create($type)
    {

        return \View::make("pages.content.edit")
            ->with('fields', config("content.types.$type.fields"))
            ->with('title', trans('content.create.title'))
            ->with('url', route('content.store', [$type]))
            ->with('type', $type)
            ->render();

    }

    public function store(Request $request, $type)
    {
        $this->validate($request, config("content.types.$type.rules"));

        $fields = ['user_id' => $request->user()->id, 'type' => $type];

        $content = \App\Content::create(array_merge($request->all(), $fields));

        return redirect()
            ->route('content.index', [$type])
            ->with('status', trans("content.store.status", ['title' => $content->title]));

    }

    public function edit($type, $id)
    {

        $content = \App\Content::findorFail($id);

        return \View::make("pages.content.edit")
            ->with('title', trans('content.create.title'))
            ->with('fields', config("content.types.$type.fields"))
            ->with('content', $content)
            ->with('method', 'put')
            ->with('url', route('content.update', [$content->type, $content]))
            ->with('type', $type)
            ->render();

    }

    public function update(Request $request, $type, $id)
    {

        $content = \App\Content::findorFail($id);

        $this->validate($request, config("content.types.$type.rules"));

        $fields = [];

        $content->update(array_merge($request->all(), $fields));

        return redirect()
            ->route('content.show', [$type, $content])
            ->with('status', trans("content.update.status", ['title' => $content->title]));

    }

    public function redirect($path)
    {
        $alias = \DB::table('content_alias')
            ->whereAlias('content/' . $path)
            ->first();

        if ($alias) {
            return redirect('content/' . $alias->content_id, 301);
        }

        abort(404);
    }

}
