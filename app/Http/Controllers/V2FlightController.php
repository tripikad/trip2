<?php

namespace App\Http\Controllers;

use App;
use Request;
use App\Image;
use App\Topic;
use App\Content;
use App\Destination;

class V2FlightController extends Controller
{
    public function index()
    {
        $currentDestination = Request::get('destination');
        $currentTopic = Request::get('topic');

        $sliceSize = 10;
        $flights = Content::getLatestPagedItems(
            'flight',
            2 * $sliceSize,
            $currentDestination,
            $currentTopic
        );

        $forums = Content::getLatestPagedItems('forum', 4, null, null, 'updated_at');
        $destinations = Destination::select('id', 'name')->get();
        $topics = Topic::select('id', 'name')->get();

        $travelmates = Content::getLatestItems('travelmate', 3);
        $news = Content::getLatestItems('news', 1);

        return layout('2col')

            ->with('title', trans('content.flight.index.title'))
            ->with('head_title', trans('content.flight.index.title'))
            ->with('head_description', trans('site.description.flight'))
            ->with('head_image', Image::getSocial())

            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->is('large')
                    ->with('title', trans('content.flight.index.title'))
                    ->with('route', route('flight.index'))
                )
                ->push(region(
                    'FilterHorizontal',
                    $destinations,
                    null,
                    $currentDestination,
                    null,
                    $flights->currentPage(),
                    'flight.index'
                ))
            ))

            ->with('content', collect()
                ->push(component('AffMomondo'))
                ->merge($flights->slice(0, $sliceSize)->map(function ($flight) {
                    return region('FlightRow', $flight);
                })
                )
                ->push(component('Promo')->with('promo', 'body'))
                ->merge($flights->slice($sliceSize)->map(function ($flight) {
                    return region('FlightRow', $flight);
                }))
                ->push(
                    region('Paginator', $flights, $currentDestination, $currentTopic)
                )
            )

            ->with('sidebar', collect()
                ->push(region('FlightAbout'))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
                ->push(component('AffHotelscombined'))

            )

            ->with('bottom', collect()
                ->push(region('FlightBottom', $forums, $travelmates, $news))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function show($slug)
    {
        $flight = Content::getItemBySlug($slug);
        $flights = Content::getLatestItems('flight', 4);
        $forums = Content::getLatestPagedItems('forum', 4, null, null, 'updated_at');
        $travelmates = Content::getLatestItems('travelmate', 3);
        $news = Content::getLatestItems('news', 1);

        $loggedUser = auth()->user();

        return layout('2col')

            ->with('title', trans('content.flight.index.title'))
            ->with('head_title', $flight->getHeadTitle())
            ->with('head_description', $flight->getHeadDescription())
            ->with('head_image', $flight->getHeadImage())

            ->with('header', region('Header', collect()
                ->push(component('Link')
                    ->is('white')
                    ->is('large')
                    ->with('title', trans('content.flight.show.action.all'))
                    ->with('route', route('flight.index'))
                )
                ->push(component('Title')
                    ->is('white')
                    ->is('large')
                    ->is('shadow')
                    ->with('title', $flight->vars()->title)
                )
                ->push(component('Meta')
                    ->with('items', collect()
                        ->push(component('MetaLink')
                            ->is('white')
                            ->with('title', $flight->vars()->created_at)
                        )
                        ->merge($flight->destinations->map(function ($destination) {
                            return component('Tag')
                                ->is('orange')
                                ->with('title', $destination->name)
                                ->with('route', route('destination.show', [$destination]));
                        }))
                        ->pushWhen($loggedUser && $loggedUser->hasRole('admin', $flight->user->id),
                            component('MetaLink')
                                ->is('white')
                                ->with('title', trans('content.action.edit.title'))
                                ->with('route', route('flight.edit', [$flight]))
                        )
                    )
                ), $flight->getHeadImage(), 'high'))

            ->with('content', collect()
                ->push(component('Body')->is('responsive')->with('body', $flight->vars()->body))
                ->merge($flight->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
                ->push(component('AffBookingInspiration'))
                ->push(region('Share'))
                ->pushWhen($loggedUser && $loggedUser->hasRole('regular'), region('CommentCreateForm', $flight))
                ->push(component('Promo')->with('promo', 'body'))
                ->push(component('Block')
                    ->with('title', trans('frontpage.index.flight.title'))
                    ->with('content', $flights->map(function ($flight) {
                        return region('FlightRow', $flight);
                    }))
                )
            )

            ->with('sidebar', collect()
                ->push(region('FlightAbout'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
                ->push(component('AffiliateSearch'))
                ->push(component('AffRentalcars'))
                ->push(component('AffBookingSearch'))
            )

            ->with('bottom', collect()
                ->push(region('FlightBottom', $forums, $travelmates, $news))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function create()
    {
        return App::make('App\Http\Controllers\ContentController')
            ->create('flight');
    }

    public function edit($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->edit('flight', $id);
    }

    public function store()
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'flight');
    }

    public function update($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'flight', $id);
    }
}
