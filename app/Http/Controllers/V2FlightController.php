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

        $forums = Content::getLatestPagedItems('forum', 3, null, null, 'updated_at');
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
                ->push(component('Promo')->with('promo', 'flightoffer_list_top'))
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
                ->push(component('Promo')->with('promo', 'flightoffer_list_sidebar'))
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
        $loggedUser = auth()->user();

        $flight = Content::getItemBySlug($slug, $loggedUser);
        $flights = Content::getLatestItems('flight', 4);
        $forums = Content::getLatestPagedItems('forum', 3, null, null, 'updated_at');
        $travelmates = Content::getLatestItems('travelmate', 3);
        $news = Content::getLatestItems('news', 1);

        return layout('2col')

            ->with('title', trans('content.flight.index.title'))
            ->with('head_title', $flight->getHeadTitle())
            ->with('head_description', $flight->getHeadDescription())
            ->with('head_image', $flight->getHeadImage())

            ->with('header', region('Header', collect()
                ->push(component('Link')
                    ->is('white')
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
                        ->pushWhen($loggedUser && $loggedUser->hasRole('admin', $flight->user->id),
                            component('MetaLink')
                                ->is('white')
                                ->with('title', trans('content.action.edit.title').'2')
                                ->with('route', route('flight.edit2', [$flight]))
                        )
                        ->pushWhen($loggedUser && $loggedUser->hasRole('admin'), component('Form')
                                ->with('route', route(
                                    'content.status',
                                    [$flight->type, $flight, (1 - $flight->status)]
                                ))
                                ->with('fields', collect()
                                    ->push(component('FormLink')
                                        ->is('white')
                                        ->with(
                                            'title',
                                            trans("content.action.status.$flight->status.title")
                                        )
                                    )
                                )
                        )
                    )
                ), $flight->getHeadImage(), 'high'))

            ->with('top', collect()->pushWhen(
                ! $flight->status,
                component('HeaderUnpublished')
                    ->with('title', trans('content.show.unpublished'))
            ))

            ->with('content', collect()
                ->push(component('Body')->is('responsive')->with('body', $flight->vars()->body))
                ->push(region('Share'))
                ->merge($flight->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
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

    public function edit2($id)
    {
        $flight = Content::findOrFail($id);
        $destinations = Destination::select('id', 'name')->orderBy('name')->get();

        return layout('1col')

            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->with('title', trans('content.flight.index.title'))
                    ->with('route', route('news.index'))
                )
            ))

            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('content.flight.edit.title'))
                )
                ->push(component('Form')
                    ->with('route', route('flight.update', [$flight]))
                    ->with('method', 'PUT')
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', trans('content.flight.edit.field.title.title'))
                            ->with('name', 'title')
                            ->with('value', old('title', $flight->title))
                        )
                        ->push(component('FormImageId')
                            ->with('title', trans('content.flight.edit.field.image_id.title'))
                            ->with('name', 'image_id')
                            ->with('value', old('image_id', $flight->image_id))
                        )
                        ->push(component('FormEditor')
                            ->with('title', trans('content.flight.edit.field.body.title'))
                            ->with('name', 'body')
                            ->with('value', [old('body', $flight->body)])
                            ->with('rows', 10)
                        )
                        /*
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'destinations')
                            ->with('options', $destinations)
                            ->with('value', $flight->destinations)
                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
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
            ->store(request(), 'flight');
    }

    public function update($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'flight', $id);
    }
}
