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
        $forums = Content::getLatestItems('forum', 4);
        $travelmates = Content::getLatestItems('travelmate', 3);

        return view('v2.layouts.2col')

            ->with('header', region('Header', trans('content.news.index.title')))

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
                ->push(component('Block')->with('content', collect()
                    ->push(region(
                        'Filter',
                        $destinations,
                        $topics,
                        $currentDestination,
                        $currentTopic,
                        $news->currentPage(),
                        'v2.news.index'
                    ))
                ))
                ->push(region('NewsAbout'))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(region('NewsBottom', $flights, $forums, $travelmates))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }

    public function show($slug)
    {
        $new = Content::getItemBySlug($slug);
        $user = auth()->user();

        $flights = Content::getLatestItems('flight', 3);
        $forums = Content::getLatestItems('forum', 4);
        $travelmates = Content::getLatestItems('travelmate', 3);

        return view('v2.layouts.1col')
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

            ->with('footer', region('Footer'));
    }

    public function edit($id)
    {
        $new = Content::getItemById($id);

        return view('v2.layouts.fullpage')
            ->with('content', collect()
                ->push(component('Editor')->with('item', $new))
            );
    }
}
