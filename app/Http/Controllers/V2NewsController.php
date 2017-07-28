<?php

namespace App\Http\Controllers;

use App;
use Log;
use Request;
use App\Image;
use App\Topic;
use App\Content;
use App\Destination;

class V2NewsController extends Controller
{
    public function shortnewsIndex()
    {
        return $this->index('shortnews');
    }

    public function index($type = 'news')
    {
        $currentDestination = Request::get('destination');
        $currentTopic = Request::get('topic');

        $news = Content::getLatestPagedItems($type, false, $currentDestination, $currentTopic);
        $destinations = Destination::select('id', 'name')->get();
        $topics = Topic::select('id', 'name')->orderBy('name', 'asc')->get();

        $flights = Content::getLatestItems('flight', 3);
        $forums = Content::getLatestPagedItems('forum', 3, null, null, 'updated_at');
        $travelmates = Content::getLatestItems('travelmate', 3);

        return layout('2col')

            ->with('title', trans('content.'.$type.'.index.title'))
            ->with('head_title', trans('content.'.$type.'.index.title'))
            ->with('head_description', trans('site.description.news'))
            ->with('head_image', Image::getSocial())

            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->is('large')
                    ->with('title', trans('content.'.$type.'.index.title'))
                    ->with('route', route('news.index'))
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('NewsLinks'))
                )
                ->push(region(
                    'FilterHorizontal',
                    $destinations,
                    $topics,
                    $currentDestination,
                    $currentTopic,
                    $news->currentPage(),
                    $type.'.index'
                ))
            ))

            ->with('content', collect()
                ->push(component('Grid3')
                    ->with('gutter', true)
                    ->with('items', $news->map(function ($new) {
                        return region('NewsCard', $new);
                    })
                    )
                )
                ->push(region('Paginator', $news, $currentDestination, $currentTopic))
            )

            ->with('sidebar', collect()
                ->push(region('NewsAbout'))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(region('NewsBottom', $flights, $forums, $travelmates))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function show($slug)
    {
        $user = auth()->user();
        $new = Content::getItemBySlug($slug, $user);

        $flights = Content::getLatestItems('flight', 3);
        $forums = Content::getLatestPagedItems('forum', 3, null, null, 'updated_at');
        $travelmates = Content::getLatestItems('travelmate', 3);

        return layout('1col')

            ->with('title', trans('content.news.index.title'))
            ->with('head_title', $new->vars()->title)
            ->with('head_description', $new->vars()->description)
            ->with('head_image', $new->getHeadImage())

            ->with('header', region('NewsHeader', $new))

            ->with('top', collect()->pushWhen(
                ! $new->status,
                component('HeaderUnpublished')
                    ->with('title', trans('content.show.unpublished'))
            ))

            ->with('content', collect()
                ->push(component('Body')->is('responsive')->with('body', $new->vars()->body))
                ->merge($new->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
                ->pushWhen($user && $user->hasRole('regular'), region('CommentCreateForm', $new))
            )

            ->with('bottom', collect()
                ->push(region('NewsBottom', $flights, $forums, $travelmates))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function create()
    {
        return App::make('App\Http\Controllers\ContentController')
            ->create('news');
    }

    public function create2()
    {
        $destinations = Destination::select('id', 'name')->orderBy('name')->get();
        $topics = Topic::select('id', 'name')->orderBy('name')->get();

        return layout('1col')

            ->with('header', region('Header', collect()
                ->push(component('EditorScript'))
                ->push(component('Title')
                    ->is('white')
                    ->with('title', trans('content.news.index.title'))
                    ->with('route', route('news.index'))
                )
            ))

            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('content.news.create.title').' (beta)')
                )
                ->push(component('Form')
                    ->with('route', route('news.store2'))
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', trans('content.news.edit.field.title.title'))
                            ->with('name', 'title')
                            ->with('value', old('title'))
                        )
                        ->push(component('FormImageId')
                            ->with('title', trans('content.news.edit.field.image_id.title'))
                            ->with('name', 'image_id')
                            ->with('value', old('image_id'))
                        )
                        ->push(component('FormTextarea')
                            ->is('hidden')
                            ->with('name', 'body')
                            ->with('value', old('body'))
                        )
                        ->push(component('FormEditor')
                            ->with('title', trans('content.news.edit.field.body.title2'))
                            ->with('name', 'body')
                            ->with('value', [old('body')])
                            ->with('rows', 10)
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'destinations')
                            ->with('options', $destinations)
                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'topics')
                            ->with('options', $topics)
                            ->with('placeholder', trans('content.index.filter.field.topic.title'))
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('content.create.title'))
                        )
                    )
                )
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function store()
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'news');
    }

    public function store2()
    {
        $loggedUser = request()->user();

        $rules = [
            'title' => 'required',
            'body' => 'required',
        ];

        $this->validate(request(), $rules);

        $news = $loggedUser->contents()->create([
            'title' => request()->title,
            'body' => request()->body,
            'type' => 'news',
            'status' => 0,
        ]);

        $news->destinations()->attach(request()->destinations);
        $news->topics()->attach(request()->topics);

        if ($imageToken = request()->image_id) {
            $imageId = str_replace(['[[', ']]'], '', $imageToken);
            $news->images()->attach([$imageId]);
        }

        Log::info('New content added', [
            'user' =>  $news->user->name,
            'title' =>  $news->title,
            'type' =>  $news->type,
            'body' =>  $news->body,
            'link' => route('news.show', [$news->slug]),
        ]);

        return redirect()
            ->route('news.show', [$news->slug])
            ->with('info', trans('content.store.info', [
                'title' => $news->title,
            ]));
    }

    public function edit($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->edit('news', $id);
    }

    public function edit2($id)
    {
        $news = Content::findOrFail($id);
        $destinations = Destination::select('id', 'name')->orderBy('name')->get();
        $topics = Topic::select('id', 'name')->orderBy('name')->get();

        return layout('1col')

            ->with('header', region('Header', collect()
                ->push(component('EditorScript'))
                ->push(component('Title')
                    ->is('white')
                    ->with('title', trans('content.news.index.title'))
                    ->with('route', route('news.index'))
                )
            ))

            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('content.news.edit.title').' (beta)')
                )
                ->push(component('Form')
                    ->with('route', route('news.update2', [$news]))
                    ->with('method', 'PUT')
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', trans('content.news.edit.field.title.title'))
                            ->with('name', 'title')
                            ->with('value', old('title', $news->title))
                        )
                        ->push(component('FormImageId')
                            ->with('title', trans('content.news.edit.field.image_id.title'))
                            ->with('name', 'image_id')
                            ->with('value', old('image_id', $news->image_id))
                        )
                        ->push(component('FormTextarea')
                            ->is('hidden')
                            ->with('name', 'body')
                            ->with('value', old('body', $news->body))
                        )
                        ->push(component('FormEditor')
                            ->with('title', trans('content.news.edit.field.body.title2'))
                            ->with('name', 'body')
                            ->with('value', [old('body', $news->body)])
                            ->with('rows', 10)
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'destinations')
                            ->with('options', $destinations)
                            ->with('value', $news->destinations->pluck('id'))
                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'topics')
                            ->with('options', $topics)
                            ->with('value', $news->topics->pluck('id'))
                            ->with('placeholder', trans('content.index.filter.field.topic.title'))
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('content.edit.submit.title'))
                        )
                    )
                )
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function update($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'news', $id);
    }

    public function update2($id)
    {
        $news = Content::findOrFail($id);

        $rules = [
            'title' => 'required',
            'body' => 'required',
        ];

        $this->validate(request(), $rules);

        $news->fill([
            'title' => request()->title,
            'body' => request()->body,
        ])
        ->save();

        $news->destinations()->sync(request()->destinations ?: []);
        $news->topics()->sync(request()->topics ?: []);

        if ($imageToken = request()->image_id) {
            $imageId = str_replace(['[[', ']]'], '', $imageToken);
            $news->images()->sync([$imageId] ?: []);
        }

        return redirect()
            ->route('blog.show', [$news->slug])
            ->with('info', trans('content.update.info', [
                'title' => $news->title,
            ]));
    }
}
