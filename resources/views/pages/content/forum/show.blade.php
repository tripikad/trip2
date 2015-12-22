@extends('layouts.main')

@section('title')

    {{ trans("content.$type.index.title") }}

@stop

@section('content')

<div class="r-forum m-single">

    <div class="r-forum__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-forum',
            'title' => 'forum'
        ])

        <div class="r-forum__map">

            <div class="r-forum__map-inner">

                @include('component.map', [
                    'modifiers' => 'm-forum'
                ])
            </div>
        </div>
    </div>

    <div class="r-forum__wrap">

        <div class="r-forum__content">

            @include('component.content.forum.post', [
                'profile' => [
                    'modifiers' => 'm-full m-status',
                    'image' => $content->user->imagePreset(),
                    'title' => $content->user->name,
                    'route' => route('user.show', [$content->user]),
                    'status' => [
                        'modifiers' => 'm-purple',
                        'position' => '3',
                        'editor' => true
                    ]
                ],
                'title' => $content->title,
                'date' => view('component.date.relative', ['date' => $content->created_at]),
                'date_edit' =>
                    $content->created_at != $content->updated_at ?
                        view('component.date.long', ['date' => $content->updated_at])
                    : null,
                'text' => $content->body_filtered,
                'actions' => view('component.actions', ['actions' => $content->getActions()]),
                'thumbs' => view('component.flags', ['flags' => $content->getFlags()]),
                'tags' => $content->destinations->transform(function ($destination) {
                    return [
                        'modifiers' => ['m-purple', 'm-yellow', 'm-red', 'm-green'][rand(0,3)],
                        'title' => $destination->name,
                        'route' => route('destination.show', [$destination->id])
                    ];
                })
            ])

            <div class="r-block m-small m-mobile-hide">

                @include('component.promo', [
                    'modifiers' => 'm-body',
                    'image' => \App\Image::getRandom(),
                    'route' => '#'
                ])

            </div>


            @if (method_exists($comments, 'currentPage'))

                @include('component.comment.index', [
                    'comments' => $comments->forPage(
                        $comments->currentPage(),
                        $comments->perPage()
                    )
                ])

            @endif

            <div class="r-block">

                @include('component.pagination.numbered', [
                    'collection' => $comments
                ])

            </div>

            @if (\Auth::check())

            <div class="r-block">

                @include('component.comment.create')

            </div>

            @endif

        </div>

        <div class="r-forum__sidebar">

            <div class="r-block m-small m-flex">

                @include('component.content.forum.nav', [
                    'items' => [
                        [
                            'title' => trans('frontpage.index.forum.general'),
                            'route' => route('content.show', 'forum'),
                            'modifiers' => 'm-large m-block m-icon',
                            'icon' => 'icon-arrow-right'
                        ],
                        [
                            'title' => trans('frontpage.index.forum.buysell'),
                            'route' => route('content.show', 'buysell'),
                            'modifiers' => 'm-large m-block m-icon',
                            'icon' => 'icon-arrow-right'
                        ],
                        [
                            'title' => trans('frontpage.index.forum.expat'),
                            'route' => route('content.show', 'expat'),
                            'modifiers' => 'm-large m-block m-icon',
                            'icon' => 'icon-arrow-right'
                        ],

                    ]
                ])

                @if (\Auth::check())

                    @include('component.content.forum.nav', [
                        'items' => [
                            [
                                'type' => 'button',
                                'title' => trans("content.$type.create.title"),
                                'route' => route('content.create', ['type' => $type]),
                                'modifiers' => 'm-secondary m-block m-shadow'
                            ]
                        ]
                    ])

                @endif

            </div>

            <div class="r-block m-small">

                @include('component.destination', [
                    'modifiers' => 'm-purple',
                    'title' => 'New York',
                    'title_route' => '/destination/4',
                    'subtitle' => 'Põhja-Ameerika',
                    'subtitle_route' => '#'
                ])

                <div class="r-block__inner">

                    <div class="r-block__header">

                        <div class="r-block__header-title">

                            @include('component.title', [
                                'modifiers' => 'm-purple',
                                'title' => trans('destination.show.forum.title')
                            ])
                        </div>
                    </div>

                    <div class="r-block__body">

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
            </div>

            <div class="r-block m-small">

                @include('component.promo', [
                    'modifiers' => 'm-sidebar-small',
                    'route' => '#',
                    'image' => \App\Image::getRandom()
                ])
            </div>

            <div class="r-block m-small">

                @include('component.destination', [
                    'modifiers' => 'm-blue',
                    'title' => 'Keenia',
                    'title_route' => '/destination/4',
                    'subtitle' => 'Aafrika',
                    'subtitle_route' => '#'
                ])

                <div class="r-block__inner">

                    <div class="r-block__header">

                        <div class="r-block__header-title">

                            @include('component.title', [
                                'modifiers' => 'm-blue',
                                'title' => trans('destination.show.forum.title')
                            ])
                        </div>
                    </div>

                    <div class="r-block__body">

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
                                        'modifiers' => 'm-inverted m-blue',
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
                                        'modifiers' => 'm-inverted m-blue',
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
                                        'modifiers' => 'm-inverted m-blue',
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
                                        'modifiers' => 'm-blue',
                                        'count' => 2
                                    ]
                                ]
                            ]
                        ])
                    </div>
                </div>
            </div>

            <div class="r-block m-small">

                @include('component.card', [
                    'route' => '#',
                    'title' => 'Stockholmist Los Angelesse, New Yorki või Seatlisse al 285 €',
                    'image' => \App\Image::getRandom()
                ])
                @include('component.card', [
                    'route' => '#',
                    'title' => 'Edasi-tagasi Riiast või Helsingist LAsse al 350 €',
                    'image' => \App\Image::getRandom()
                ])
            </div>

        </div>

    </div>

    @if (count($forums) || count($travel_mates) || count($flights))

        <div class="r-forum__additional">
            <div class="r-forum__additional-wrap">

                @if (count($forums))

                    <div class="r-block">
                        <div class="r-block__header">

                            @include('component.title', [
                                'modifiers' => 'm-red',
                                'title' => trans('destination.show.forum.title')
                            ])

                        </div>
                        <div class="r-forum__additional-column m-first">

                            @include('component.content.forum.nav', [
                                'items' => [
                                    [
                                        'title' => trans('frontpage.index.forum.general'),
                                        'route' => route('content.show', 'forum'),
                                        'modifiers' => 'm-large m-block m-icon',
                                        'icon' => 'icon-arrow-right'
                                    ],
                                    [
                                        'title' => trans('frontpage.index.forum.buysell'),
                                        'route' => route('content.show', 'buysell'),
                                        'modifiers' => 'm-large m-block m-icon',
                                        'icon' => 'icon-arrow-right'
                                    ],
                                    [
                                        'title' => trans('frontpage.index.forum.expat'),
                                        'route' => route('content.show', 'expat'),
                                        'modifiers' => 'm-large m-block m-icon',
                                        'icon' => 'icon-arrow-right'
                                    ]
                                ]
                            ])

                        </div>
                        <div class="r-forum__additional-column m-last">

                            @include('component.content.forum.list', [
                                'items' => $forums->transform(function ($forum) {
                                    return [
                                        'topic' => str_limit($forum->title, 50),
                                        'route' => route('content.show', [$forum->type, $forum]),
                                        'date' => view('component.date.relative', [
                                            'date' => $forum->created_at
                                        ]),
                                        'profile' => [
                                            'modifiers' => 'm-mini',
                                            'image' => $forum->user->imagePreset()
                                        ],
                                        'badge' => [
                                            'modifiers' => 'm-inverted',
                                            'count' => $forum->comments->count()
                                        ],
                                        'tags' => $forum->destinations->take(2)->transform(function ($destination, $key) use ($forum) {
                                            return [
                                                'title' => $destination->name,
                                                'modifiers' => ['m-green', 'm-blue', 'm-orange', 'm-yellow', 'm-red'][$key],
                                                'route' => route('content.show', [$forum->type]).'?topic='.$destination->id,
                                            ];
                                        })
                                    ];
                                })
                            ])
                        </div>
                    </div>

                @endif

                @if (count($flights))

                    <div class="r-block">
                        <div class="c-columns m-{{ count($flights) }}-cols">

                            @foreach ($flights as $flight)

                                <div class="c-columns__item">

                                    @include('component.card', [
                                        'route' => route('content.show', [$flight->type, $flight]),
                                        'title' => $flight->title.' '.$flight->price.' '.config('site.currency.symbol'),
                                        'image' => $flight->imagePreset()
                                    ])

                                </div>

                            @endforeach

                        </div>
                    </div>

                @endif

                @if (count($travel_mates))

                    <div class="r-block">
                        <div class="r-block__header">
                            @include('component.title', [
                                'title' => trans('frontpage.index.travelmate.title'),
                                'modifiers' => 'm-red'
                            ])
                        </div>

                        @include('component.travelmate.list', [
                            'modifiers' => 'm-'.count($travel_mates).'col',
                            'items' => $travel_mates->transform(function ($travel_mate) {
                                return [
                                    'modifiers' => 'm-small',
                                    'image' =>  $travel_mate->imagePreset(),
                                    'name' =>
                                        $travel_mate->user->real_name ?
                                            $travel_mate->user->real_name
                                        :
                                            $travel_mate->user->name,
                                    'route' => route('content.show', [$travel_mate->type, $travel_mate]),
                                    'sex_and_age' =>
                                        ($travel_mate->user->gender ?
                                            trans('user.gender.'.$travel_mate->user->gender).
                                            ($travel_mate->user->age ? ', ' : '')
                                        : null).
                                        ($travel_mate->user->age ? $travel_mate->user->age : null),
                                    'title' => $travel_mate->title,
                                    'tags' => $travel_mate->destinations->transform(function ($destination) {
                                        return [
                                            'modifiers' => ['m-purple', 'm-yellow', 'm-red', 'm-green'][rand(0,3)],
                                            'title' => $destination->name
                                        ];
                                    })
                                ];
                            })
                        ])

                    </div>

                @endif

            </div>
        </div>

    @endif

    <div class="r-forum__footer-promo">

        <div class="r-forum__footer-promo-wrap">

            @include('component.promo', [
                'modifiers' => 'm-footer',
                'route' => '#',
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
