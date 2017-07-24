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
        $topics = Topic::select('id', 'name')->orderBy('name', 'asc')->get();

        $flights = Content::getLatestItems('flight', 3);
        $forums = Content::getLatestPagedItems('forum', 3, null, null, 'updated_at');
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
        $user = auth()->user();
        $travelmate = Content::getItemBySlug($slug, $user);

        $travelmates = Content::getLatestItems('travelmate', 3);

        $flights = Content::getLatestItems('flight', 3);
        $forums = Content::getLatestPagedItems('forum', 3, null, null, 'updated_at');
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

            ->with('top', collect()->pushWhen(
                ! $travelmate->status,
                component('HeaderUnpublished')
                    ->with('title', trans('content.show.unpublished'))
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
                        ->pushWhen($user && $user->hasRole('admin'), component('Form')
                                ->with('route', route(
                                    'content.status',
                                    [$travelmate->type, $travelmate, (1 - $travelmate->status)]
                                ))
                                ->with('fields', collect()
                                    ->push(component('FormLink')
                                        ->with(
                                            'title',
                                            trans("content.action.status.$travelmate->status.title")
                                        )
                                    )
                                )
                        )
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

    public function createExperiment()
    {
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();
        $topics = Destination::select('id', 'name')->orderBy('name', 'asc')->get();

        for($i = 0; $i <= 4; $i++) {
            $date = strtotime('+'.$i.' month');
            $dates[] = [
                'name' => trans('date.month.'.date('m', $date)).' '.date('Y', $date),
                'output' => date('Y-m', $date)
            ];
        }
        $dates[] = ['name' =>getSeason(date('Y-m', strtotime('+6 month'))), 'output' => date('Y-m', strtotime('+5 month'))];

        dump($dates);

        return layout('2col')

            ->with('narrow', true)

            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')

            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->with('title', trans('content.travelmate.index.title'))
                    ->with('route', route('forum.index'))
                )
            ))

            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('content.travelmate.create.title'))
                )
                ->push(component('Form')
                    ->with('id', 'ForumCreateForm')
                    //->with('route', route('travelmate.store'))
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', trans('content.forum.edit.field.title.title'))
                            ->with('name', 'title')
                            ->with('value', old('title'))
                        )
                        ->push(component('FormTextarea')
                            ->with('title', trans('content.forum.edit.field.body.title'))
                            ->with('name', 'body')
                            ->with('value', old('title'))
                            ->with('rows', 20)
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
                        ->push('<div style="border-radius: 4px; opacity: 0.2; height: 3rem; border: 2px dashed black; font-family: Sailec; display: flex; align-items: center; justify-content: center;">Alustan reisi kuupäeval (komponent)</div>')
                        ->push(component('TravelMateStart')
                            ->with('dates', $dates)
                        )
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', trans('content.travelmate.edit.field.duration.title'))
                            ->with('name', 'duration') // Is it correct?
                            ->with('value', old('duration'))
                        )
                        ->push(component('FormButton')
                            ->with('disabled', true)
                            ->with('title', trans('content.create.submit.title'))
                        )

                    )
                )
            )

            ->with('sidebar', collect()
                ->push(component('Block')
                    ->is('gray')
                    ->with('content', collect()
                        ->push(component('Title')
                            ->is('smaller')
                            ->is('red')
                            ->with('title', trans('content.edit.notes.heading'))
                            ->with('route', route('forum.index'))
                        )
                        ->push(component('Body')
                            ->with('body', trans('content.edit.notes.body'))
                        )
                ))
            )

            ->with('footer', region('Footer'))

            ->render();
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
