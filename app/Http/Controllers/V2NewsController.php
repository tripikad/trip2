<?php

namespace App\Http\Controllers;

use Request;
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

            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->is('large')
                    ->with('title', trans('content.news.index.title'))
                    ->with('route', route('v2.news.index'))
                )
                ->push(region(
                    'FilterHorizontal',
                    $destinations,
                    $topics,
                    $currentDestination,
                    $currentTopic,
                    $news->currentPage(),
                    'v2.news.index'
                ))
            ))

            ->with('content', collect()
                ->push(component('Grid2')
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
        $new = Content::getItemBySlug($slug);
        $user = auth()->user();

        $flights = Content::getLatestItems('flight', 3);
        $forums = Content::getLatestPagedItems('forum', 4, null, null, 'updated_at');
        $travelmates = Content::getLatestItems('travelmate', 3);

        return layout('1col')

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
}
