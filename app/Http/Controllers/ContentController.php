<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Auth;
use Cache;
use App\Main;
use App\Image;
use App\Topic;
use App\Content;
use Carbon\Carbon;
use App\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\ContentTraits\Blog;
// Traits
use App\Http\Controllers\ContentTraits\Forum;
use App\Http\Controllers\ContentTraits\Flight;
use Illuminate\Pagination\LengthAwarePaginator;
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

        if (config("content_$type.store.status", 1) == 0 && Auth::check() && Auth::user()->hasRole('admin')) {
            $comments_status = 0;
        } else {
            $comments_status = 1;
        }

        if (in_array('comments', config("content_$type.index.with")) && ($type == 'forum' || $type == 'buysell' || $type == 'expat' || $type == 'internal')) {
            $contents = Content::leftJoin('comments', function ($query) use ($comments_status) {
                $query->on('comments.content_id', '=', 'contents.id')
                    ->on('comments.id', '=',
                        DB::raw('(select id from comments where `content_id` = `contents`.`id` order by id desc limit 1)'));
            })
                ->where('contents.type', $type)
                ->with(config("content_$type.index.with"))
                ->select(['contents.*', DB::raw('IF(UNIX_TIMESTAMP(comments.created_at) > UNIX_TIMESTAMP(contents.created_at), comments.created_at, contents.created_at) AS contentOrder')])
                ->orderBy('contentOrder', 'desc');
        } else {
            $contents = Content::whereType($type)
                ->with(config("content_$type.index.with"))
                ->orderBy(
                    config("content_$type.index.orderBy.field"),
                    config("content_$type.index.orderBy.order")
                );
        }

        if ($comments_status != 0) {
            $contents->where('contents.status', $comments_status);
        }

        $expireField = config("content_$type.index.expire.field");
        if ($expireField) {
            $expireData = Main::getExpireData($type, 0);
            if (in_array($expireField, $expireData)) {
                if (($key = array_search($expireField, $expireData)) !== false) {
                    unset($expireData[$key]);
                }

                $contents = $contents->whereRaw('`contents`.`'.$expireField.'` >= ?', [
                    array_values($expireData)[0],
                ]);
            } else {
                $contents = $contents->whereBetween('contents.'.$expireField, [
                    $expireData['daysFrom'],
                    $expireData['daysTo'],
                ]);
            }
        }

        if ($request->destination) {
            $descendants = Destination::find($request->destination)
                ->descendantsAndSelf()
                ->pluck('id');

            $contents = $contents
                ->join('content_destination', 'content_destination.content_id', '=', 'contents.id')
                ->whereIn('content_destination.destination_id', $descendants);
        }

        if ($request->topic) {
            $contents = $contents
                ->join('content_topic', 'content_topic.content_id', '=', 'contents.id')
                ->where('content_topic.topic_id', '=', $request->topic);
        }

        if ($request->author) {
            $contents = $contents->where('contents.user_id', $request->author);
        }

        $contents = $contents->simplePaginate(config('content_'.$type.'.index.paginate'));

        $queryParameters = [];
        $queryString = '';

        if (isset($request->destination) && $request->destination) {
            $queryParameters[] = 'destination='.$request->destination;
        }

        if (isset($request->topic) && $request->topic) {
            $queryParameters[] = 'topic='.$request->topic;
        }

        if (! empty($queryParameters) && count($queryParameters)) {
            $queryString = '?'.implode('&', $queryParameters);
        }

        $contents->setPath(route($type.'.index').$queryString);

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

    public function findBySlugAndType($type, $slug)
    {
        $content = Content::where('slug', $slug)->where('type', $type)->firstOrFail();
        if (! $content) {
            abort(404);
        }

        return $this->show($type, $content->id);
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

        if ($type !== 'static') {
            $comments->setPath(route($type.'.show', [$content->slug]));
        }

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

    public function showWithRedirect($type, $id)
    {
        $content = Content::findorFail($id);

        if ('static' === $type) {
            return redirect()->route(
                'static.'.$id, [], 301);
        }

        return redirect()->route(
            $type.'.show', [$content->slug], 301);
    }

    public function create($type)
    {
        $destinations = Destination::getNames();
        $destination = [];

        $topics = Topic::getNames();
        $topic = [];

        $now = \Carbon\Carbon::now();

        $viewType = $type;
        foreach (config('menu.forum') as $item) {
            if ($type == $item['type']) {
                $viewType = 'forum';
                break;
            }
        }

        if (view()->exists('pages.content.'.$viewType.'.edit')) {
            $view = 'pages.content.'.$viewType.'.edit';
        } else {
            $view = 'pages.content.edit';
        }

        $viewVariables = [
            'mode' => 'create',
            'fields' => config("content_$type.edit.fields"),
            'url' => route('content.store', [$type]),
            'type' => $type,
            'destinations' => $destinations,
            'destination' => $destination,
            'topics' => $topics,
            'topic' => $topic,
            'now' => $now,
        ];

        return response()
            ->view($view, $viewVariables)
            ->header('Cache-Control', 'public, s-maxage='.config('cache.content.create.header'));
    }

    public function edit($type, $id)
    {
        $now = \Carbon\Carbon::now();

        $content = \App\Content::findorFail($id);

        $destinations = Destination::getNames();
        $destination = $content->destinations()->select('destinations.id')->pluck('id')->toArray();

        $topics = Topic::getNames();
        $topic = $content->topics()->select('topics.id')->pluck('id')->toArray();

        $viewType = $type;
        foreach (config('menu.forum') as $item) {
            if ($type == $item['type']) {
                $viewType = 'forum';
                break;
            }
        }

        if (view()->exists('pages.content.'.$viewType.'.edit')) {
            $view = 'pages.content.'.$viewType.'.edit';
        } else {
            $view = 'pages.content.edit';
        }

        $viewVariables = [
            'mode' => 'edit',
            'fields' => config("content_$type.edit.fields"),
            'content' => $content,
            'method' => 'put',
            'url' => route('content.update', [$content->type, $content]),
            'type' => $type,
            'destinations' => $destinations,
            'destination' => $destination,
            'topics' => $topics,
            'topic' => $topic,
            'now' => $now,
        ];

        return response()
            ->view($view, $viewVariables)
            ->header('Cache-Control', 'public, s-maxage='.config('cache.content.edit.header'));
    }

    protected function fetchTypesArray($array = [])
    {
        $types = [];
        foreach ($array as $key => $value) {
            $types[] = $value['type'];
        }

        return $types;
    }

    public function store(Request $request, $type, $id = null)
    {
        if (Auth::user()) {
            $user_id = Auth::user()->id;
            $content = null;
            if ($id) {
                $content = Content::findorFail($id);
            } else {
                $content = new Content();
            }

            $columns = array_flip(\DB::connection()->getSchemaBuilder()->getColumnListing('contents'));
            $protectedColumns = ['id', 'user_id', 'created_at', 'updated_at'];

            foreach ($protectedColumns as $protectedColumn) {
                if (isset($columns[$protectedColumn])) {
                    unset($columns[$protectedColumn]);
                }
            }
            $columns = array_flip($columns);

            $allowedFields = config('content_'.$type.'.edit.fields');
            if ($request->has('type') && isset($allowedFields['type']) && isset($allowedFields['type']['items'])) {
                $allowedTypes = $this->fetchTypesArray(config($allowedFields['type']['items']));
                if (in_array($request->type, $allowedTypes)) {
                    $allowedFields = config('content_'.$request->type.'.edit.fields');
                }
            }

            if (! $id) {
                $validator = config("content_$type.add.validate") ? config("content_$type.add.validate") : config("content_$type.edit.validate");

                $content->user_id = $user_id;
                $content->type = $type;
                $content->status = config("content_$type.store.status", 1);
            } else {
                $validator = config("content_$type.edit.validate");
            }

            $request->merge(
                self::fetchDates($request, $type)
            );

            $this->validate($request, $validator);
            foreach ($request->all() as $key => $value) {
                if (array_key_exists($key, $allowedFields) && in_array($key, $columns)) {
                    if ($key == 'type' && isset($allowedFields['type']['items'])) {
                        $allowedTypes = $this->fetchTypesArray(config($allowedFields['type']['items']));

                        if (! in_array($value, $allowedTypes)) {
                            $value = $type;
                        } else {
                            $type = $value;
                        }
                    } elseif ($key == 'type' && ! isset($allowedFields['type']['items'])) {
                        $value = $type;
                    }

                    $content->$key = $value;
                }
            }

            if ($id) {
                if ($request->hasFile('file') && array_key_exists('file', $allowedFields)) {
                    $old_image = $content->images()->first();

                    if ($old_image) {
                        $filename = $old_image->filename;
                        $filepath = config('imagepresets.original.path').$filename;
                        unlink($filepath);

                        foreach (['large', 'medium', 'small', 'small_square', 'xsmall_square'] as $preset) {
                            $filepath = config("imagepresets.presets.$preset.path").$filename;
                            unlink($filepath);
                        }
                    }

                    $filename = Image::storeImageFile($request->file('file'));
                    $content->images()->update(['filename' => $filename]);
                }
            }

            $content->save();

            if (in_array($content->type, ['forum', 'buysell', 'expat', 'internal'])) {
                
                DB::table('users')->select('id')->chunk(1000, function ($users) use ($content) {
                    collect($users)->each(function ($user) use ($content) {

                        // For user we store the cache key about new content item

                        $key = 'new_'.$content->id.'_'.$user->id;

                        // Cache value is initially 0 (no new comments are added yet)
                        // Note: not sure about set for x seconds / set forever / auto-expiration yet

                        Cache::store('permanent')->forever($key, 0);

                    });
                });
                
            }

            Log::info('New content added', [
                'user' =>  Auth::user()->name,
                'title' =>  $request->get('title'),
                'type' =>  $type,
                'body' =>  $request->get('body'),
                'link' => route('content.show', [$type, $content]),
            ]);

            if (! $id) {
                if ($request->hasFile('file') && array_key_exists('file', $allowedFields)) {
                    $filename = Image::storeImageFile($request->file('file'));
                    $content->images()->create(['filename' => $filename]);
                }
            }

            if ($request->has('image_id') && array_key_exists('image_id', $allowedFields)) {
                $image_id = str_replace(['[[', ']]'], '', $request->image_id);

                if ($image_id && Image::find($image_id)) {
                    $content->images()->sync([$image_id]);
                }
            } elseif (! array_key_exists('image_id', $allowedFields) && count($content->images) && ! array_key_exists('file', $allowedFields) && count($content->images)) {
                $old_images = $content->images;

                if (count($old_images)) {
                    foreach ($old_images as $old_image) {
                        $filename = $old_image->filename;
                        $filepath = config('imagepresets.original.path').$filename;
                        unlink($filepath);

                        foreach (['large', 'medium', 'small', 'small_square', 'xsmall_square'] as $preset) {
                            $filepath = config("imagepresets.presets.$preset.path").$filename;
                            unlink($filepath);
                        }
                    }
                }
                $content->images()->delete();
            }

            if ($request->has('destinations') && array_key_exists('destinations', $allowedFields)) {
                $content->destinations()->sync($request->destinations);
            } elseif (! array_key_exists('destinations', $allowedFields) && count($content->destinations)) {
                $content->destinations()->delete();
            }

            if ($request->has('topics') && array_key_exists('topics', $allowedFields)) {
                $content->topics()->sync($request->topics);
            } elseif (! array_key_exists('topics', $allowedFields) && count($content->topics)) {
                $content->topics()->delete();
            }

            if (! $request->ajax()) {
                if (! $id) {
                    return redirect()
                        ->route($type.'.index')
                        ->with('info', trans('content.store.status.'.config("content_$type.store.status", 1).'.info', [
                            'title' => $content->title,
                        ]));
                } else {
                    return redirect()
                        ->route($type.'.show', [$content->slug])
                        ->with('info', trans('content.update.info', [
                            'title' => $content->title,
                        ]));
                }
            }
        } else {
            return redirect()
                ->route($type.'.index');
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
                /*$time = Carbon::createFromTime(
                    $request->{$name.'_hour'},
                    $request->{$name.'_minute'},
                    $request->{$name.'_second'}
                )->format('H:i:s');*/
                $time = '00:00:00';
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
            $type.'.index',
            [
                'destination' => $request->destination ? $request->destination : null,
                'topic' => $request->topic ? $request->topic : null,
                'author' => $request->author ? $request->author : null,
            ]
        );
    }
}
