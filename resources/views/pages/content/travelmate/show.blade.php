@extends('layouts.main')

@section('title', trans("content.$type.index.title"))

@section('header')
    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])
@stop

@section('content')

<div class="r-travelmates m-single">
    <div class="r-travelmates__masthead">
        @include('component.masthead', [
            'modifiers' => 'm-alternative',
            'image' => \App\Image::getHeader(),
            'subtitle' => trans('content.travelmate.view.all.offers'),
            'subtitle_route' => route($content->type.'.index')
        ])
    </div>

    <div class="r-travelmates__wrap">
        <div class="r-travelmates__content m-first">
            <h1 class="r-travelmates__title">{{ $content->title }}</h1>

            <div class="r-travelmates__meta">

                <div class="r-travelmates__meta-item">
                    <ul class="c-inline-list m-light m-small">
                        <li class="c-inline-list__item">
                            {{ trans('content.travelmate.post.added', [
                                'created_at' => view('component.date.relative', [
                                    'date' => $content->created_at
                                ])
                            ]) }}
                        </li>
                        @include('component.actions.list', ['actions' => $content->getActions()])
                    </ul>
                </div>

                    @if (count($content->topics) || count($content->destinations))
                    @php
                    (count($content->topics) ? $content_topics = $content->topics->transform(function ($content_topic) {
                        return [
                                'modifiers' => 'm-gray',
                                'title' => $content_topic->name
                        ];
                    }) : $content_topics = collect([]));
                    (count($content->destinations) ? $content_destinations = $content->destinations->transform(function ($content_destination) {
                        return [
                                'modifiers' => ['m-purple', 'm-yellow', 'm-red', 'm-green'][rand(0,3)],
                                'route' => route('destination.showSlug', [$content_destination->slug]),
                                'title' => $content_destination->name
                        ];
                    }) : $content_destinations = collect([]));
                    @endphp
                    <div class="r-travelmates__meta-item">
                        @include('component.tags', [
                            'modifiers' => 'm-small',
                            'items' => array_merge($content_topics->toArray(), $content_destinations->toArray()),
                        ])
                    </div>
                    @endif
            </div>

            <div class="r-travelmates__content-body">
                <div class="c-body">

                    {!! $content->body_filtered !!}

                </div>
            </div>
        </div>

        <div class="r-travelmates__sidebar m-first">
            <div class="r-block m-small">

                @include('component.travelmate.user', [
                    'modifiers' => 'm-purple',
                    'image' => $content->user->imagePreset('small_square'),
                    'letter' => [
                        'modifiers' => 'm-purple',
                        'text' => (strlen($content->user->name) ? $content->user->name[0] : '')
                    ],
                    'user' => $content->user,
                    'name' => $content->user->name,
                    'user_route' => ($content->user->name != 'Tripi külastaja' ? route('user.show', [$content->user]) : false),
                    'sex_and_age' =>
                        ($content->user->gender ?
                            trans('user.gender.'.$content->user->gender).
                                ($content->user->age ? ', ' : '')
                        : null).
                        ($content->user->age ? $content->user->age : null),
                    'description' => null,
                    'social_items' => [
                        [
                            'icon' => 'icon-facebook',
                            'route' => $content->user->contact_facebook
                        ],
                        [
                            'icon' => 'icon-instagram',
                            'route' => $content->user->contact_instagram
                        ],
                        [
                            'icon' => 'icon-twitter',
                            'route' => $content->user->contact_twitter
                        ],
                        [
                            'icon' => 'icon-plus',
                            'route' => $content->user->contact_homepage
                        ],
                    ]
                ])

                @include('component.travelmate.trip', [
                    'trip_start' => view('component.date.short', [
                        'date' => $content->start_at
                    ]),
                    'trip_duration' => $content->duration,
                    'trip_mate' => null
                ])

            </div>
        </div>
    </div>

    <div class="r-travelmates__wrap">
        <div class="r-travelmates__content">
            <div class="r-block">
                <div class="r-block__inner">
                    <div class="r-block__header">
                        <div class="r-block__header-title">
                            @include('component.title', [
                                'title' => trans('content.share.post.title'),
                                'modifiers' => 'm-large m-green'
                            ])
                        </div>
                    </div>
                    <div class="r-block__body">
                        @include('component.facebook')
                    </div>
                </div>
            </div>

            @if(count($comments) > 0)
                <div class="r-block">
                    <div class="r-block__header">
                        @include('component.title', [
                            'title' => trans('content.comments.title'),
                            'modifiers' => 'm-purple'
                        ])
                    </div>
                    <div class="r-block__body">
                        @include('component.comment.index', [
                            'comments' => $comments
                        ])
                    </div>
                </div>
            @endif

            @if (\Auth::check())
                <div class="r-block">
                    <div class="r-block__inner">
                        <div class="r-block__header">

                            @include('component.title', [
                                'title' => trans('content.action.add.comment'),
                                'modifiers' => 'm-large m-green'
                            ])

                        </div>
                        <div class="r-block__body">

                            @include('component.comment.create')

                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="r-travelmates__sidebar">
            <div class="r-block m-small">
                @if ($destination && $parent_destination)
                    @include('component.destination', [
                        'modifiers' => 'm-purple',
                        'title' => $destination ? $destination->name : null,
                        'title_route' => $destination ? route('destination.showSlug', $destination->slug) : null,
                        'subtitle' => $parent_destination ? $parent_destination->name : null,
                        'subtitle_route' => $parent_destination ? route('destination.showSlug', $parent_destination->slug) : null,
                    ])
                @endif

                @if (count($sidebar_flights))
                    @foreach ($sidebar_flights as $sidebar_flight)
                        @include('component.card', [
                            'modifiers' => 'm-purple',
                            'route' => route($sidebar_flight->type.'.show', [$sidebar_flight->slug]),
                            'title' => $sidebar_flight->title.' '.$sidebar_flight->price.config('site.currency.symbol'),
                            'image' => $sidebar_flight->imagePreset()
                        ])
                    @endforeach
                @endif

                @if (isset($forums) && count($forums))
                    <div class="r-block__inner">
                        <div class="r-block__header">
                            <div class="r-block__header-title m-flex">
                                @include('component.title', [
                                    'modifiers' => 'm-purple',
                                    'title' => trans('destination.show.forum.title')
                                ])
                            </div>
                        </div>
                        @include('region.content.forum.list', [
                            'modifiers' => [
                                'main' => 'm-compact',
                                'letter' => 'm-red',
                                'badge' => 'm-inverted m-purple',
                            ],
                            'items' => $forums,
                        ])
                    </div>
                @endif
            </div>

            @include('component.promo', ['promo' => 'sidebar_small m-small-margin'])

        </div>
    </div>

    @if (count($flights))
        <div class="r-travelmates__offers">
            <div class="r-travelmates__offers-wrap">
                @include('region.content.flight.card', [
                    'items' => $flights
                ])
            </div>
        </div>
    @endif

    @if (isset($travel_mates) && count($travel_mates))
        @if (isset($flights) && count($flights))
        <div class="r-travelmates__additional m-padding">
        @else
        <div class="r-travelmates__additional">
        @endif

            <div class="r-travelmates__additional-wrap">
                @include('region.content.travelmate.list', [
                    'items' => $travel_mates
                ])
            </div>
        </div>
    @endif

    <div class="r-travelmates__footer-promo">
        <div class="r-travelmates__footer-promo-wrap">
           @include('component.promo', ['promo' => 'footer'])
        </div>
    </div>
</div>
@stop

@section('footer')
    @include('component.footer', [
        'modifiers' => 'm-alternative',
        'image' => \App\Image::getFooter()
    ])
@stop
