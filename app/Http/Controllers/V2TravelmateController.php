<?php

namespace App\Http\Controllers;

use App;
use Log;
use Request;
use App\Image;
use App\Topic;
use App\Content;
use Carbon\Carbon;
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
            ->with('head_title', $travelmate->vars()->title)
            ->with('head_description', $travelmate->vars()->description)
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
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();
        $topics = Topic::select('id', 'name')->orderBy('name', 'asc')->get();

        $dates = collect();

        foreach (range(0, 6) as $i) {
            $now = Carbon::now()->startOfDay();
            $nextDate = $now->addMonths($i)->startOfMonth();
            $dates->push([
                'datetime' => $nextDate, // 2017-08-01 00:00:00
                'title' => $nextDate->format('M Y')
                    .($i > 5 ? ' '.trans('content.travelmate.edit.field.start_at.suffix') : ''), // Oct 2017
            ]);
        }

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
                    ->with('route', route('travelmate.store'))
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
                            ->with('value', old('body'))
                            ->with('rows', 15)
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
                        ->push(component('FormTextfield')
                            ->is('hidden')
                            ->with('name', 'start_at')
                        )
                        ->push(component('TravelmateStart')
                            ->with('name', 'start_at')
                            ->with('dates', $dates)
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.travelmate.edit.field.duration.title'))
                            ->with('name', 'duration')
                            ->with('value', old('duration'))
                        )
                        ->push(component('FormButton')
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
        $travelmate = Content::findOrFail($id);
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();
        $topics = Topic::select('id', 'name')->orderBy('name', 'asc')->get();

        $dates = collect();

        foreach (range(0, 6) as $i) {
            $now = Carbon::now()->startOfDay();
            $nextDate = $now->addMonths($i)->startOfMonth();
            $dates->push([
                'datetime' => $nextDate, // 2017-08-01 00:00:00
                'title' => $nextDate->format('M Y')
                    .($i > 5 ? ' '.trans('content.travelmate.edit.field.start_at.suffix') : ''), // Oct 2017
            ]);
        }

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
                    ->with('title', trans('content.travelmate.edit.title'))
                )
                ->push(component('Form')
                    ->with('route', route('travelmate.update', [$travelmate]))
                    ->with('method', 'PUT')
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', trans('content.forum.edit.field.title.title'))
                            ->with('name', 'title')
                            ->with('value', old('title', $travelmate->title))
                        )
                        ->push(component('FormTextarea')
                            ->with('title', trans('content.forum.edit.field.body.title'))
                            ->with('name', 'body')
                            ->with('value', old('body', $travelmate->body))
                            ->with('rows', 15)
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'destinations')
                            ->with('options', $destinations)
                            ->with('value', $travelmate->destinations->pluck('id'))
                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'topics')
                            ->with('options', $topics)
                            ->with('value', $travelmate->topics->pluck('id'))
                            ->with('placeholder', trans('content.index.filter.field.topic.title'))
                        )
                        ->push(component('FormTextfield')
                            ->is('hidden')
                            ->with('name', 'start_at')
                            ->with('value', $travelmate->start_at)
                        )
                        ->push(component('TravelmateStart')
                            ->with('name', 'start_at')
                            ->with('dates', $dates)
                            ->with('value', old('start_at', $travelmate->start_at))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.travelmate.edit.field.duration.title'))
                            ->with('name', 'duration')
                            ->with('value', old('duration', $travelmate->duration))
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('content.edit.submit.title'))
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

    public function store()
    {
        $loggedUser = request()->user();

        $rules = [
            'title' => 'required',
            'body' => 'required',
            'start_at' => 'date',
        ];

        $this->validate(request(), $rules);

        $travelmate = $loggedUser->contents()->create([
            'title' => request()->title,
            'body' => request()->body,
            'type' => 'travelmate',
            'status' => 1,
            'start_at' => Carbon::parse(request()->start_at)->startOfDay(),
            'duration' => request()->duration,
        ]);

        $travelmate->destinations()->attach(request()->destinations);
        $travelmate->topics()->attach(request()->topics);

        Log::info('New content added', [
            'user' =>  $travelmate->user->name,
            'title' =>  $travelmate->title,
            'type' =>  $travelmate->type,
            'body' =>  $travelmate->body,
            'link' => route('travelmate.show', [$travelmate->slug]),
        ]);

        return redirect()
            ->route('travelmate.index')
            ->with('info', trans('content.store.info', [
                'title' => $travelmate->title,
            ]));
    }

    public function update($id)
    {
        $travelmate = Content::findOrFail($id);

        $rules = [
            'title' => 'required',
            'body' => 'required',
            'start_at' => 'date',
        ];

        $this->validate(request(), $rules);

        $travelmate->fill([
            'title' => request()->title,
            'body' => request()->body,
            'start_at' => Carbon::parse(request()->start_at),
            'duration' => request()->duration,
        ])
        ->save();

        $travelmate->destinations()->sync(request()->destinations ?: []);
        $travelmate->topics()->sync(request()->topics ?: []);

        return redirect()
            ->route('travelmate.show', [$travelmate->slug])
            ->with('info', trans('content.update.info', [
                'title' => $travelmate->title,
            ]));
    }
}
