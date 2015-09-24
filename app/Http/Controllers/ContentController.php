<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Imageconv;

use App\Content;
use App\Destination;
use App\Topic;
use App\Image;

class ContentController extends Controller
{

    public function index(Request $request, $type)
    {
        
        if ($type == 'internal'
            && (!Auth::check() || (Auth::check() && !Auth::user()->hasRole('admin')))
        ) {
            abort(401);
        }

        $contents = Content::whereType($type)
            ->with(config("content_$type.index.with"))
            ->latest(config("content_$type.index.latest"))
            ->whereStatus(1);
            
        if ($request->destination) {

            $descendants = Destination::find($request->destination)
                ->descendantsAndSelf()
                ->lists('id');

            $contents = $contents
                ->join('content_destination', 'content_destination.content_id', '=', 'contents.id')
                ->select('contents.*')
                ->whereIn('content_destination.destination_id', $descendants);
        }   

        if ($request->topic) {

            $contents = $contents
                ->join('content_topic', 'content_topic.content_id', '=', 'contents.id')
                ->select('contents.*')
                ->where('content_topic.topic_id', '=', $request->topic);
        
        } 

        $contents = $contents->simplePaginate(config("content_$type.index.paginate"));

        $destinations = Destination::getNames($type);
        $topics = Topic::getNames($type);

        $view = view()->exists("pages.content.$type.index") ? "pages.content.$type.index" : 'pages.content.index';

        return response()->view($view, [
            'contents' => $contents,
            'type'  => $type,
            'destination' => $request->destination,
            'destinations' => $destinations,
            'topic' => $request->topic,
            'topics' => $topics,
        ])->header('Cache-Control', 'public, s-maxage=' . config('site.cache.content.index'));
    }


    public function show($type, $id)
    {
        
        if ($type == 'internal'
            && (!Auth::check() || (Auth::check() && !Auth::user()->hasRole('admin')))
        ) {
            abort(401);
        }

        $content = \App\Content::with('user', 'comments', 'comments.user', 'flags', 'comments.flags', 'flags.user', 'comments.flags.user', 'destinations', 'topics', 'carriers')
            ->findorFail($id);
             
        $comments = $content->comments->filter(function ($comment) {
            return $comment->status || (Auth::check() && Auth::user()->hasRole('admin'));
        });

        $view = view()->exists("pages.content.$type.show") ? "pages.content.$type.show" : 'pages.content.show';

        return response()->view($view, [
            'content' => $content,
            'comments' => $comments,
            'type' => $type
        ])->header('Cache-Control', 'public, s-maxage=' . config('site.cache.content.show'));
    
    }

    public function create($type)
    {

        $destinations = Destination::getNames();
        $destination = [];

        $topics = Topic::getNames();
        $topic = [];

        $now = \Carbon\Carbon::now();

        return \View::make("pages.content.edit")
            ->with('mode', 'create')
            ->with('fields', config("content_$type.edit.fields"))
            ->with('url', route('content.store', [$type]))
            ->with('type', $type)
            ->with('destinations', $destinations)
            ->with('destination', $destination)
            ->with('topics', $topics)
            ->with('topic', $topic)
            ->with('now', $now)
            ->render();

    }

    public function store(Request $request, $type)
    {
        $this->validate($request, config("content_$type.edit.validate"));

        $fields = [
            'type' => $type,
            'status' => config("content_$type.store.status", 1)
        ];

        $content = Auth::user()->contents()->create(array_merge($request->all(), $fields));

        if ($request->hasFile('file')) {
            
            $filename = $this->storeImage($request->file('file'), $type);
            $content->images()->create(['filename' => $filename]);

        }

        if ($request->has('image_id')) {
            
            $id = str_replace(['[[', ']]'], '', $request->image_id);

            if (is_int($id) && Image::find($id)) {
            
                $content->images()->sync($id);
            
            }

        }

        if ($request->has('destinations')) {
            
            $content->destinations()->sync($request->destinations);

        }

        if ($request->has('topics')) {
            
            $content->topics()->sync($request->topics);

        }

        return redirect()
            ->route('content.index', [$type])
            ->with('info', trans("content.store.status." . config("content_$type.store.status", 1) . '.info', [
                'title' => $content->title
            ]));

    }

    public function edit($type, $id)
    {

        $now = \Carbon\Carbon::now();

        $content = \App\Content::findorFail($id);

        $destinations = Destination::getNames();
        $destination = $content->destinations()->select('destinations.id')->lists('id')->toArray();

        $topics = Topic::getNames();
        $topic = $content->topics()->select('topics.id')->lists('id')->toArray();

        return \View::make("pages.content.edit")
            ->with('mode', 'edit')
            ->with('fields', config("content_$type.edit.fields"))
            ->with('content', $content)
            ->with('method', 'put')
            ->with('url', route('content.update', [$content->type, $content]))
            ->with('type', $type)
            ->with('destinations', $destinations)
            ->with('destination', $destination)
            ->with('topics', $topics)
            ->with('topic', $topic)
            ->with('now', $now)
            ->render();

    }

    public function update(Request $request, $type, $id)
    {

        $content = \App\Content::findorFail($id);

        $this->validate($request, config("content_$type.edit.validate"));

        $fields = [];
        
        if ($request->hasFile('file')) {
            
            $filename = $this->storeImage($request->file('file'), $type);
            $content->images()->update(['filename' => $filename]);

        }

        $content->update(array_merge($fields, $request->all()));

        if ($request->has('image_id')) {
            
            $id = (int)str_replace(['[[', ']]'], '', $request->image_id);

            if ($id && Image::find($id)) {
                
                $content->images()->sync([$id]);
            
            }

        }

        if ($request->has('destinations')) {
            
            $content->destinations()->sync($request->destinations);

        }

        if ($request->has('topics')) {
            
            $content->topics()->sync($request->topics);

        }

        return redirect()
            ->route('content.show', [$type, $content])
            ->with('info', trans("content.update.info", ['title' => $content->title]));

    }


    public function storeImage($file, $type)
    {

        $fileName = $file->getClientOriginalName();
        $fileName = preg_replace('/\s+/', '-', $fileName);
        $path = config('imagepresets.original.path');
        
        $file->move($path, $fileName);

        Imageconv::make($path . $fileName)
            ->resize(
                config('imagepresets.small.width'),
                config('imagepresets.small.height'),
                function ($constraint) {
                    $constraint->aspectRatio();
            })
            ->save(config('imagepresets.small.path') . $fileName);

        Imageconv::make($path . $fileName)
            ->resize(
                config('imagepresets.medium.width'),
                config('imagepresets.medium.height'),
                function ($constraint) {
                    $constraint->aspectRatio();
            })
            ->save(config('imagepresets.medium.path') . $fileName);

        Imageconv::make($path . $fileName)
            ->resize(
                config('imagepresets.large.width'),
                config('imagepresets.large.height'),
                function ($constraint) {
                    $constraint->aspectRatio();
            })
            ->save(config('imagepresets.large.path') . $fileName);

        return $fileName;
    
    }

    public function status($type, $id, $status)
    {

        $content = \App\Content::findorFail($id);

        if ($status == 0 || $status == 1) {

            $content->status = $status;
            $content->save();

            return redirect()
                ->route('content.show', [$type, $content])
                ->with('info', trans("content.action.status.$status.info", [
                    'title' => $content->title
                ]));
        }
        
        return back();

    }

    public function filter(Request $request, $type)
    {
        
        return redirect()->route(
            'content.index',
            [$type,
            'destination' => $request->destination ? $request->destination : null,
            'topic' => $request->topic ? $request->topic : null,
            ]
        );

    }

}
