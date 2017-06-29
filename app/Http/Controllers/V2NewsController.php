<?php

namespace App\Http\Controllers;

use App;
use Request;
use App\Image;
use App\Topic;
use App\Content;
use App\Destination;

class V2NewsController extends Controller
{
    public function index()
    {
        $currentDestination = Request::get('destination');
        $currentTopic = Request::get('topic');

        $news = Content::getLatestPagedItems('news', false, $currentDestination, $currentTopic);
        $destinations = Destination::select('id', 'name')->get();
        $topics = Topic::select('id', 'name')->orderBy('name', 'asc')->get();

        $flights = Content::getLatestItems('flight', 3);
        $forums = Content::getLatestPagedItems('forum', 3, null, null, 'updated_at');
        $travelmates = Content::getLatestItems('travelmate', 3);

        return layout('2col')

            ->with('title', trans('content.news.index.title'))
            ->with('head_title', trans('content.news.index.title'))
            ->with('head_description', trans('site.description.news'))
            ->with('head_image', Image::getSocial())

            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->is('large')
                    ->with('title', trans('content.news.index.title'))
                    ->with('route', route('news.index'))
                )
                ->push(region(
                    'FilterHorizontal',
                    $destinations,
                    $topics,
                    $currentDestination,
                    $currentTopic,
                    $news->currentPage(),
                    'news.index'
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
            ->with('head_title', $new->getHeadTitle())
            ->with('head_description', $new->getHeadDescription())
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

    public function edit($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->edit('news', $id);
    }

    public function edit2($id)
    {
        $news = Content::findOrFail($id);
        $destinations = Destination::select('id', 'name')->orderBy('name')->get();
        $topics = Destination::select('id', 'name')->orderBy('name')->get();

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
                    ->with('title', trans('content.news.edit.title'))
                )
                ->push(component('Form')
                    ->with('route', route('news.update', [$news]))
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
                        ->push(component('FormEditor')
                            ->with('title', trans('content.news.edit.field.body.title'))
                            ->with('name', 'body')
                            ->with('value', [old('body', $news->body)])
                            ->with('rows', 10)
                        )
                        /*
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'destinations')
                            ->with('options', $destinations)
                            ->with('value', $news->destinations)
                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'topics')
                            ->with('options', $topics)
                            ->with('value', $news->topics)
                            ->with('placeholder', trans('content.index.filter.field.topic.title'))
                        )
                        */
                        ->push(component('FormButton')
                            ->with('title', trans('content.edit.submit.title'))
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

    public function update($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'news', $id);
    }
}
