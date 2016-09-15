<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;
use App\Topic;

class V2NewsController extends Controller
{
    public function index()
    {
        $news = Content::getLatestPagedItems('news');
        $destinations = Destination::select('id', 'name')->get();
        $topics = Topic::select('id', 'name')->get();

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
            )

            ->with('sidebar', collect()
                ->push(region('NewsAbout'))
                ->push(component('Block')->with('content', collect()
                        ->push(region('Filter', $destinations, $topics))
                    )
                )
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('footer', region('Footer'));
    }

    public function show($slug)
    {
        $new = Content::getItemBySlug($slug);
        $user = auth()->user();

        return view('v2.layouts.1col')
            ->with('header', region('NewsHeader', $new))
            ->with('content', collect()
                ->push(component('Body')->is('responsive')->with('body', $new->vars()->body))
                ->merge($new->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
                ->pushWhen($user && $user->hasRole('regular'), region('CommentCreateForm', $new))
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
