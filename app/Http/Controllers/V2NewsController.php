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
        $topics = Topic::select('id', 'name')->get();

        $flights = Content::getLatestItems('flight', 3);
        $forums = Content::getLatestPagedItems('forum', 4, null, null, 'updated_at');
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
        $forums = Content::getLatestPagedItems('forum', 4, null, null, 'updated_at');
        $travelmates = Content::getLatestItems('travelmate', 3);

        return layout('1col')

            ->with('title', trans('content.news.index.title'))
            ->with('head_title', $new->getHeadTitle())
            ->with('head_description', $new->getHeadDescription())
            ->with('head_image', $new->getHeadImage())

            ->with('header', region('NewsHeader', $new))

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
