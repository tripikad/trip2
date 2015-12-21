@extends('layouts.main')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

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
            'image' => \App\Image::getRandom(),
            'subtitle' => trans('content.travelmate.view.all.offers'),
            'subtitle_route' => route('content.index', [$content->type])
        ])

    </div>

    <div class="r-travelmates__wrap">
        <div class="r-travelmates__content">
            <h1 class="r-travelmates__title">{{ $content->title }}</h1>

            <div class="r-travelmates__meta">
                @include('component.actions', ['actions' => $content->getActions()])

                <p class="r-travelmates__meta-date">
                    {{ trans('content.travelmate.post.added', [
                        'created_at' => view('component.date.relative', [
                            'date' => $content->created_at
                        ])
                    ]) }}
                </p>

                @if (count($content->destinations))

                    @include('component.tags', [
                        'modifiers' => 'm-small',
                        'items' => $content->destinations->transform(function ($content_destination) {
                            return [
                                'modifiers' => ['m-purple', 'm-yellow', 'm-red', 'm-green'][rand(0,3)],
                                'route' => route('destination.show', [$content_destination->id]),
                                'title' => $content_destination->name
                            ];
                        })
                    ])

                @endif

            </div>

            @if (count($content->topics))

                <div class="r-travelmates__meta">

                    @include('component.tags', [
                        'modifiers' => 'm-small',
                        'items' => $content->topics->transform(function ($content_topic) {
                            return [
                                'modifiers' => 'm-gray',
                                'title' => $content_topic->name
                            ];
                        })
                    ])

                </div>

            @endif

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
                    'user' => $content->user,
                    'name' => $content->user->name,
                    'user_route' => route('content.show', [$content->type, $content]),
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

                @include('component.destination', [
                    'modifiers' => 'm-purple',
                    'title' => 'New Delhi',
                    'title_route' => '#',
                    'subtitle' => 'India',
                    'subtitle_route' => '#'
                ])

                @include('component.card', [
                    'modifiers' => 'm-purple',
                    'route' => '#',
                    'title' => 'Edasi-tagasi Riiast või Helsingist Delhisse al 350 €',
                    'image' => \App\Image::getRandom()
                ])

                @include('component.card', [
                    'modifiers' => 'm-purple',
                    'route' => '#',
                    'title' => 'Stockholmist Delhisse, Goasse või Mumbaisse al 285 €',
                    'image' => \App\Image::getRandom()
                ])

                <div class="r-block__inner">
                    <div class="r-block__header">

                        @include('component.title', [
                            'modifiers' => 'm-purple',
                            'title' => 'Tripikad räägivad'
                        ])

                    </div>

                    @include('component.content.forum.list', [
                        'modifiers' => 'm-compact',
                        'items' => [
                            [
                                'topic' => 'Samui hotellid?',
                                'route' => '#',
                                'profile' => [
                                    'modifiers' => 'm-mini',
                                    'image' => \App\Image::getRandom()
                                ],
                                'badge' => [
                                    'modifiers' => 'm-inverted m-purple',
                                    'count' => 9
                                ]
                            ],
                            [
                                'topic' => 'Soodsalt inglismaal rongi/metroo/bussiga? Kus hindu vaadata?',
                                'route' => '#',
                                'profile' => [
                                    'modifiers' => 'm-mini',
                                    'image' => \App\Image::getRandom()
                                ],
                                'badge' => [
                                    'modifiers' => 'm-inverted m-purple',
                                    'count' => 4
                                ]
                            ],
                            [
                                'topic' => 'Puhkuseosakud Tenerifel',
                                'route' => '#',
                                'profile' => [
                                    'modifiers' => 'm-mini',
                                    'image' => \App\Image::getRandom()
                                ],
                                'badge' => [
                                    'modifiers' => 'm-inverted m-purple',
                                    'count' => 2
                                ]
                            ],
                            [
                                'topic' => 'Ischgl mäeolud-pilet ja majutus',
                                'route' => '#',
                                'profile' => [
                                    'modifiers' => 'm-mini',
                                    'image' => \App\Image::getRandom()
                                ],
                                'badge' => [
                                    'modifiers' => 'm-purple',
                                    'count' => 2
                                ]
                            ]
                        ]
                    ])

                </div>
            </div>

            <div class="r-block m-small">

                @include('component.promo', [
                    'modifiers' => 'm-sidebar-small',
                    'route' => '',
                    'image' => \App\Image::getRandom()
                ])

            </div>
        </div>
    </div>

    <div class="r-travelmates__offers">
        <div class="r-travelmates__offers-wrap">
            <div class="c-columns m-3-cols">
                <div class="c-columns__item">

                    @include('component.card', [
                        'modifiers' => 'm-purple',
                        'route' => '#',
                        'title' => 'Edasi-tagasi Riiast või Helsingist Delhisse al 350 €',
                        'image' => \App\Image::getRandom()
                    ])

                </div>

                <div class="c-columns__item">

                    @include('component.card', [
                        'modifiers' => 'm-purple',
                        'route' => '#',
                        'title' => 'Stockholmist Delhisse, Goasse või Mumbaisse al 285 €',
                        'image' => \App\Image::getRandom()
                    ])

                </div>

                <div class="c-columns__item">

                    @include('component.card', [
                        'modifiers' => 'm-purple',
                        'route' => '#',
                        'title' => 'Edasi-tagasi Riiast või Helsingist Delhisse al 350 €',
                        'image' => \App\Image::getRandom()
                    ])

                </div>
            </div>
        </div>
    </div>

    @if (count($travel_mates))

        <div class="r-travelmates__additional">
            <div class="r-travelmates__additional-wrap">

                @include('component.travelmate.list', [
                    'modifiers' => 'm-3col',
                    'items' => $travel_mates->transform(function ($travel_mate) {
                        return [
                            'modifiers' => 'm-small',
                            'image' => $travel_mate->user->imagePreset('small_square'),
                            'name' => $travel_mate->user->name,
                            'route' => route('content.show', [$travel_mate->type, $travel_mate]),
                            'sex_and_age' =>
                                ($travel_mate->user->gender ?
                                    trans('user.gender.'.$travel_mate->user->gender).
                                    ($travel_mate->user->age ? ', ' : '')
                                : null).
                                ($travel_mate->user->age ? $travel_mate->user->age : null),
                            'title' => $travel_mate->title,
                            'tags' => $travel_mate->destinations->transform(function ($travel_mate_destination) {
                                return [
                                    'modifiers' => ['m-purple', 'm-yellow', 'm-red', 'm-green'][rand(0,3)],
                                    'title' => $travel_mate_destination->name
                                ];
                            })
                        ];
                    })
                ])

            </div>
        </div>

    @endif

    <div class="r-travelmates__footer-promo">
        <div class="r-travelmates__footer-promo-wrap">

            @include('component.promo', [
                'modifiers' => 'm-footer',
                'route' => '',
                'image' => \App\Image::getRandom()
            ])

        </div>
    </div>

</div>

@stop

@section('footer')

    @include('component.footer', [
        'modifiers' => 'm-alternative',
        'image' => \App\Image::getRandom()
    ])

@stop
