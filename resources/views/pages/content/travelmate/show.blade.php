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
            'subtitle' => 'Vaata kõiki pakkumisi',
            'subtitle_route' => route('content.index', [$content->type])
        ])

    </div>

    <div class="r-travelmates__wrap">
        <div class="r-travelmates__content">
            <h1 class="r-travelmates__title">{{ $content->title }}</h1>

            <div class="r-travelmates__meta">
                <p class="r-travelmates__meta-date">
                    {{ trans('content.post.added', [
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

            {{--

            @include('component.row', [
                'profile' => [
                    'modifiers' => '',
                    'image' => $content->user->imagePreset(),
                    'route' => route('user.show', [$content->user])
                ],
                'modifiers' => 'm-image',
                'title' => $content->title,
                'text' => view('component.content.text', ['content' => $content]),
                'actions' => view('component.actions', ['actions' => $content->getActions()]),
                'extra' => view('component.flags', ['flags' => $content->getFlags()]),
                'body' => $content->body_filtered,
            ])

            --}}

        </div>

        <div style="display: none">
            @include('component.actions', ['actions' => $content->getActions()])
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

                    @include('component.content.forum.post',[
                        'profile' => [
                            'modifiers' => 'm-full m-status',
                            'image' => \App\Image::getRandom(),
                            'title' => 'Charles Darwin',
                            'route' => '',
                            'status' => [
                                'modifiers' => 'm-blue',
                                'position' => '1'
                            ]
                        ],
                        'actions' => view('component.actions', ['actions' => $content->getActions()]),
                        'date' => '12. jaanuar, 12:31',
                        'text' => '<p>Mina puurisin nüüd juba mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid.</p><p>Kuna mul oli plaanis arengumaades maapiirkondades kohalikke (arvatavasti) igasuguse litsentsita reisijuhte kasutada, näiteks kuskilt väikesest kohast ümberkaudsete külade üleöö külastamiseks ehk pikad jalgsimatkad mägistes piirkondades, oli tarvis, et juhul kui juhtub õnnetus, see ka korvatakse. Tegemist ei olnud siis spordiga, vaid lihtsalt keskmisest veidi koormavamate matkadega. Kokkuvõttes oli sel ajal vaid Ifil kindlustuses selline asi sees, sai ka kirjalikult üle küsitud (et oleks tõestusmaterjal hiljem!) ning teised firmad pakkusid seda lisakaitse all päris räiga lisahinnaga või ei võtnud üldse jutule, kui giidi litsentsi poleks ette näidata.</p>',
                    ])

                    @include('component.content.forum.post',[
                        'profile' => [
                            'modifiers' => 'm-full m-status',
                            'image' => \App\Image::getRandom(),
                            'title' => 'Charles Darwin',
                            'route' => '',
                            'status' => [
                                'modifiers' => 'm-blue',
                                'position' => '1'
                            ]
                        ],
                        'actions' => view('component.actions', ['actions' => $content->getActions()]),
                        'date' => '12. jaanuar, 12:31',
                        'text' => '<p>Tegemist ei olnud siis spordiga, vaid lihtsalt keskmisest veidi koormavamate matkadega. Kokkuvõttes oli sel ajal vaid Ifil kindlustuses selline asi sees, sai ka kirjalikult üle küsitud (et oleks tõestusmaterjal hiljem!) ning teised firmad pakkusid seda lisakaitse all päris räiga lisahinnaga või ei võtnud üldse jutule, kui giidi litsentsi poleks ette näidata.</p>',
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

    <div class="r-travelmates__additional">
        <div class="r-travelmates__additional-wrap">

            @include('component.travelmate.list', [
                'modifiers' => 'm-3col',
                'items' => [
                    [
                        'modifiers' => 'm-small',
                        'image' =>  \App\Image::getRandom(),
                        'name' => 'Charles Darwin',
                        'route' => '#',
                        'sex_and_age' => 'N,28',
                        'title' => 'Otsin reisikaaslast Indiasse märtsis ja/või aprillis',
                        'tags' => [
                            [
                                'modifiers' => 'm-yellow',
                                'title' => 'India'
                            ],
                            [
                                'modifiers' => 'm-purple',
                                'title' => 'Delhi'
                            ]
                        ]
                    ],
                    [
                        'modifiers' => 'm-small',
                        'image' =>  \App\Image::getRandom(),
                        'name' => 'Epptriin ',
                        'route' => '#',
                        'sex_and_age' => 'N,22',
                        'title' => 'Suusareis Austriasse veebruar-märts 2016',
                        'tags' => [
                            [
                                'modifiers' => 'm-red',
                                'title' => 'Austria'
                            ],
                            [
                                'modifiers' => 'm-gray',
                                'title' => 'Suusareis'
                            ]
                        ]
                    ],
                    [
                        'modifiers' => 'm-small',
                        'image' =>  \App\Image::getRandom(),
                        'name' => 'Silka ',
                        'route' => '#',
                        'sex_and_age' => 'M,32',
                        'title' => 'Puerto Rico',
                        'tags' => [
                            [
                                'modifiers' => 'm-green',
                                'title' => 'Puerto Rico'
                            ],
                            [
                                'modifiers' => 'm-gray',
                                'title' => 'Puhkusereis'
                            ]
                        ]
                    ]
                ]
            ])

        </div>
    </div>

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
