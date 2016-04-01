<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use App\Content;
use App\Destination;
use App\Topic;
use App\Image;
use App\Main;
use Illuminate\Pagination\LengthAwarePaginator;
// Traits
use App\Http\Controllers\ContentTraits\Blog;
use App\Http\Controllers\ContentTraits\Flight;
use App\Http\Controllers\ContentTraits\Forum;
use App\Http\Controllers\ContentTraits\Travelmate;

class ContentController extends Controller
{
    use Blog, Flight, Forum, Travelmate;

    public function index(Request $request, $type)
    {
        if ($type == 'internal'
            && (! Auth::check() || (Auth::check() && ! Auth::user()->hasRole('admin')))
        ) {
            abort(401);
        }

        $contents = Content::whereType($type)
            ->with(config("content_$type.index.with"))
            ->orderBy(
                config("content_$type.index.orderBy.field"),
                config("content_$type.index.orderBy.order")
            )
            ->whereStatus(1);

        $expireField = config("content_$type.index.expire.field");
        if ($expireField) {
            $expireData = Main::getExpireData($type, 0);
            if (in_array($expireField, $expireData)) {
                if (($key = array_search($expireField, $expireData)) !== false) {
                    unset($expireData[$key]);
                }

                $contents = $contents->whereRaw('`'.$expireField.'` >= ?', [
                    array_values($expireData)[0],
                ]);
            } else {
                $contents = $contents->whereBetween($expireField, [
                    $expireData['daysFrom'],
                    $expireData['daysTo'],
                ]);
            }
        }

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

        if ($request->author) {
            $contents = $contents->where('user_id', $request->author);
        }

        $contents = $contents->simplePaginate(config('content_'.$type.'.index.paginate'));

        $destinations = Destination::getNames($type);
        $topics = Topic::getNames($type);

        if (view()->exists('pages.content.'.$type.'.index')) {
            $view = 'pages.content.'.$type.'.index';
        } elseif (view()->exists(config('content_'.$type.'.view.index'))) {
            $view = config('content_'.$type.'.view.index');
        } else {
            $view = 'pages.content.index';
        }

        if ($type == 'travelmate') {
            $viewVariables = $this->getTravelMateIndex();
        } elseif ($type == 'forum' || $type == 'expat' || $type == 'buysell') {
            $viewVariables = $this->getForumIndex();
        } elseif ($type == 'flight') {
            $viewVariables = $this->getFlightIndex($contents, $topics);
        }

        $viewVariables['contents'] = $contents;
        $viewVariables['type'] = $type;
        $viewVariables['destination'] = $request->destination;
        $viewVariables['destinations'] = $destinations;
        $viewVariables['topic'] = $request->topic;
        $viewVariables['topics'] = $topics;

        return response()
            ->view($view, $viewVariables)
            ->header('Cache-Control', 'public, s-maxage='.config('cache.content.index.header'));
    }

    public function show($type, $id)
    {
        if ($type == 'internal'
            && (! Auth::check() || (Auth::check() && ! Auth::user()->hasRole('admin')))
        ) {
            abort(401);
        }

        $content = Content::with('user', 'comments', 'comments.user', 'flags', 'comments.flags', 'flags.user', 'comments.flags.user', 'destinations', 'topics', 'carriers');

        $content = $content->findorFail($id);

        $comments = $content->comments->filter(function ($comment) {
            return $comment->status || (Auth::check() && Auth::user()->hasRole('admin'));
        });

        $comments = new LengthAwarePaginator(
            $comments,
            $comments->count(),
            config('content_'.$type.'.index.paginate')
        );
        $comments->setPath(route('content.show', [$type, $id]));

        if (view()->exists('pages.content.'.$type.'.show')) {
            $view = 'pages.content.'.$type.'.show';
        } elseif (view()->exists(config('content_'.$type.'.view.show'))) {
            $view = config('content_'.$type.'.view.show');
        } else {
            $view = 'pages.content.show';
        }

        if ($type == 'travelmate') {
            $viewVariables = $this->getTravelMateShow($content);
        } elseif ($type == 'forum' || $type == 'expat' || $type == 'buysell' || $type == 'internal') {
            $viewVariables = $this->getForumShow($content);
        } elseif ($type == 'flight') {
            $viewVariables = $this->getFlightShow($content);
        }

        $viewVariables['content'] = $content;
        $viewVariables['comments'] = $comments;
        $viewVariables['type'] = $type;

        return response()
            ->view($view, $viewVariables)
            ->header('Cache-Control', 'public, s-maxage='.config('cache.content.show.header'));
    }

    public function create($type)
    {
        $destinations = Destination::getNames();
        $destination = [];

        $topics = Topic::getNames();
        $topic = [];

        $now = \Carbon\Carbon::now();

        if (view()->exists('pages.content.'.$type.'.edit')) {
            $view = 'pages.content.'.$type.'.edit';
        } else {
            $view = 'pages.content.edit';
        }

        return \View::make($view)
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
        $validator = config("content_$type.add.validate") ? config("content_$type.add.validate") : config("content_$type.edit.validate");

        $request->merge(
            self::fetchDates($request, $type)
        );

        $this->validate($request, $validator);

        $fields = [
            'type' => $type,
            'status' => config("content_$type.store.status", 1),
        ];

        $content = Auth::user()->contents()->create(array_merge($request->all(), $fields));

        if ($request->hasFile('file')) {
            $filename = Image::storeImageFile($request->file('file'));
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

        if (! $request->ajax()) {
            return redirect()
                ->route('content.index', [$type])
                ->with('info', trans('content.store.status.'.config("content_$type.store.status", 1).'.info', [
                    'title' => $content->title,
                ]));
        }
    }

    public function edit($type, $id)
    {
        $now = \Carbon\Carbon::now();

        $content = \App\Content::findorFail($id);

        $destinations = Destination::getNames();
        $destination = $content->destinations()->select('destinations.id')->lists('id')->toArray();

        $topics = Topic::getNames();
        $topic = $content->topics()->select('topics.id')->lists('id')->toArray();

        if (view()->exists('pages.content.'.$type.'.edit')) {
            $view = 'pages.content.'.$type.'.edit';
        } else {
            $view = 'pages.content.edit';
        }

        return \View::make($view)
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

        $request->merge(
            self::fetchDates($request, $type)
        );

        $this->validate($request, config("content_$type.edit.validate"));

        $fields = [];

        if ($request->hasFile('file')) {
            $old_image = $content->images()->first();

            if ($old_image) {
                $filename = $old_image->filename;
                $filepath = public_path().config('imagepresets.original.path').$filename;
                unlink($filepath);

                foreach (['large', 'medium', 'small', 'small_square', 'xsmall_square'] as $preset) {
                    $filepath = public_path().config("imagepresets.presets.$preset.path").$filename;
                    unlink($filepath);
                }
            }

            $filename = Image::storeImageFile($request->file('file'));
            $content->images()->update(['filename' => $filename]);
        }

        $content->update(array_merge($fields, $request->all()));

        if ($request->has('image_id')) {
            $id = (int) str_replace(['[[', ']]'], '', $request->image_id);

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

        if (! $request->ajax()) {
            return redirect()
                ->route('content.show', [$type, $content])
                ->with('info', trans('content.update.info', ['title' => $content->title]));
        }
    }

    private static function fetchDates($request, $type)
    {
        $dates_only = collect(config("content_$type.edit.fields"))->where('type', 'datetime');

        $fields = [];

        foreach ($dates_only as $name => $value) {
            if (! $request->{$name}) {
                $date = Carbon::createFromDate(
                    $request->{$name.'_year'},
                    $request->{$name.'_month'},
                    $request->{$name.'_day'}
                )->format('Y-m-d');
                $time = Carbon::createFromTime(
                    $request->{$name.'_hour'},
                    $request->{$name.'_minute'},
                    $request->{$name.'_second'}
                )->format('H:i:s');
                $fields[$name] = $date.' '.$time;
            }
        }

        return $fields;
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
                    'title' => $content->title,
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
                'author' => $request->author ? $request->author : null,
            ]
        );
    }
}
