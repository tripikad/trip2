<?php

namespace App\Http\Controllers;

use App;
use Request;
use App\Image;
use App\Topic;
use App\Content;
use App\Destination;

class V2TravelmateController extends Controller
{
    public function index()
    {
        $currentDestination = Request::get('destination');
        $currentTopic = Request::get('topic');

        $travelmates = Content::getLatestPagedItems('travelmate', 24, $currentDestination, $currentTopic);
        $destinations = Destination::select('id', 'name')->get();
        $topics = Topic::select('id', 'name')->get();

        $flights = Content::getLatestItems('flight', 3);
        $forums = Content::getLatestPagedItems('forum', 4, null, null, 'updated_at');
        $news = Content::getLatestItems('news', 1);

        return layout('2col')

            ->with('title', trans('content.travelmate.index.title'))
            ->with('head_title', trans('content.travelmate.index.title'))
            ->with('head_description', trans('site.description.travelmate'))
            ->with('head_image', Image::getSocial())

            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->is('large')
                    ->with('title', trans('content.travelmate.index.title'))
                    ->with('route', route('travelmate.index'))
                )
                ->push(region(
                    'FilterHorizontal',
                    $destinations,
                    $topics,
                    $currentDestination,
                    $currentTopic,
                    $travelmates->currentPage(),
                    'travelmate.index'
                ))
            ))

            ->with('content', collect()
                ->push(component('Grid2')
                        ->with('gutter', true)
                        ->with('items', $travelmates->map(function ($travelmate) {
                            return region('TravelmateCard', $travelmate);
                        })
                    )
                )
                ->push(region('Paginator', $travelmates, $currentDestination, $currentTopic))
            )

            ->with('sidebar', collect()
                ->push(region('TravelmateAbout'))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(region('TravelmateBottom', $flights, $forums, $news))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function show($slug)
    {
        $travelmate = Content::getItemBySlug($slug);
        $user = auth()->user();

        $travelmates = Content::getLatestItems('travelmate', 3);

        $flights = Content::getLatestItems('flight', 3);
        $forums = Content::getLatestPagedItems('forum', 4, null, null, 'updated_at');
        $news = Content::getLatestItems('news', 1);

        return layout('2col')

            ->with('title', trans('content.travelmate.index.title'))
            ->with('head_title', $travelmate->getHeadTitle())
            ->with('head_description', $travelmate->getHeadDescription())
            ->with('head_image', Image::getSocial())

            ->with('header', region('Header', collect()
                ->push(component('Link')
                    ->is('white')
                    ->is('large')
                    ->with('title', trans('content.travelmate.view.all.offers'))
                    ->with('route', route('travelmate.index'))
                )
                ->push(component('Title')
                    ->is('white')
                    ->is('large')
                    ->with('title', trans('content.travelmate.index.title'))
                    ->with('route', route('travelmate.index'))
                )
            ))

            ->with('content', collect()
                ->push(component('Title')->with('title', $travelmate->vars()->title))
                ->push(component('Meta')
                    ->with('items', collect()
                        ->push(component('MetaLink')
                            ->with('title', $travelmate->vars()->created_at)
                        )
                        ->pushWhen(
                            $user && $user->hasRoleOrOwner('admin', $travelmate->user->id),
                            component('MetaLink')
                                ->with('title', trans('content.action.edit.title'))
                                ->with('route', route('travelmate.edit', [$travelmate]))
                        )
                        ->merge($travelmate->destinations->map(function ($tag) {
                            return component('Tag')->is('orange')->with('title', $tag->name);
                        }))
                        ->merge($travelmate->topics->map(function ($tag) {
                            return component('MetaLink')->with('title', $tag->name);
                        }))
                    )
                )
                ->push(component('Body')->is('responsive')->with('body', $travelmate->vars()->body))
                ->push(region('Share'))
                ->merge($travelmate->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
                ->pushWhen(
                    $user && $user->hasRole('regular'),
                    region('CommentCreateForm', $travelmate)
                )
            )

            ->with('sidebar', collect()
                ->push(region('UserCard', $travelmate->user))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(region('TravelmateBottom', $flights, $forums, $news))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function create()
    {
        return App::make('App\Http\Controllers\ContentController')
            ->create('travelmate');
    }

    public function edit($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->edit('travelmate', $id);
    }

    public function store()
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'travelmate');
    }

    public function update($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'travelmate', $id);
    }
}
