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
            'subtitle' => 'Vaata kõiki pakkumisi ›'
        ])
    </div>

    <div class="r-travelmates__wrap">

        <div class="r-travelmates__content">

            <h1 class="r-travelmates__title">{{ $content->title }}</h1>

            <div class="r-travelmates__meta">

                <p class="r-travelmates__meta-date">Lisatud eile 12.32</p>

                @include('component.tags', [
                    'modifiers' => 'm-small',
                    'items' => [
                        [
                            'modifiers' => 'm-yellow',
                            'route' => '',
                            'title' => 'Delhi'
                        ],
                        [
                            'modifiers' => 'm-purple',
                            'route' => '',
                            'title' => 'India'
                        ],
                    ]
                ])
            </div>

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

        <div class="r-travelmates__sidebar m-first">

            <div class="r-block m-small">

                @include('component.travelmate.user', [
                    'modifiers' => 'm-purple',
                    'image' => \App\Image::getRandom(),
                    'name' => 'Charles Dawson',
                    'user_route' => '#',
                    'sex_and_age' => 'M,34',
                    'description' => '<p>I’m a 28 year-old who loves travelling to discover places and to meet people all over the world.</p>',
                    'social_items' => [
                        [
                            'icon' => 'icon-facebook',
                            'route' => '#'
                        ],
                        [
                            'icon' => 'icon-instagram',
                            'route' => '#'
                        ],
                        [
                            'icon' => 'icon-twitter',
                            'route' => '#'
                        ],
                        [
                            'icon' => 'icon-plus',
                            'route' => '#'
                        ],
                    ]
                ])

                @include('component.travelmate.trip', [
                    'trip_start' => 'Märts, 2016',
                    'trip_duration' => '9 kuud – aasta',
                    'trip_mate' => 'Kõik sobib'
                ])
            </div>

        </div>

    </div>

    <div class="r-travelmates__wrap">

        <div class="r-travelmates__content">

            <div class="r-block">

                <div class="r-block__inner">

                    <div class="r-block__header">

                        @include('component.title', [
                            'title' => 'Soovita pakkumist sõpradele',
                            'modifiers' => 'm-large m-purple'
                        ])
                    </div>
                </div>
            </div>

            <div class="r-block">

                <div class="r-block__header">

                    @include('component.title', [
                        'title' => 'Kommentaarid',
                        'modifiers' => 'm-purple'
                    ])
                </div>

                <div class="r-block__body">

                    @include('component.comment.index', ['comments' => $comments])

                    @include('component.content.forum.post',[
                        'profile' => [
                            'image' => \App\Image::getRandom(),
                            'title' => 'Charles Darwin',
                            'route' => ''
                        ],
                        'date' => '12. jaanuar, 12:31',
                        'text' => '<p>Mina puurisin nüüd juba mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid.</p><p>Kuna mul oli plaanis arengumaades maapiirkondades kohalikke (arvatavasti) igasuguse litsentsita reisijuhte kasutada, näiteks kuskilt väikesest kohast ümberkaudsete külade üleöö külastamiseks ehk pikad jalgsimatkad mägistes piirkondades, oli tarvis, et juhul kui juhtub õnnetus, see ka korvatakse. Tegemist ei olnud siis spordiga, vaid lihtsalt keskmisest veidi koormavamate matkadega. Kokkuvõttes oli sel ajal vaid Ifil kindlustuses selline asi sees, sai ka kirjalikult üle küsitud (et oleks tõestusmaterjal hiljem!) ning teised firmad pakkusid seda lisakaitse all päris räiga lisahinnaga või ei võtnud üldse jutule, kui giidi litsentsi poleks ette näidata.</p>',
                    ])

                    @include('component.content.forum.post',[
                        'profile' => [
                            'image' => \App\Image::getRandom(),
                            'title' => 'Charles Darwin',
                            'route' => ''
                        ],
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
                            'title' => 'Lisa kommentaar',
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