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
                'date_edit' => '10. jaanuar, 17:14',
                'text' => $content->body_filtered,
                'actions' => view('component.actions', ['actions' => $content->getActions()]),
                'thumbs' => view('component.flags', ['flags' => $content->getFlags()]),
                'tags' => [
                    [
                        'modifiers' => 'm-blue',
                        'title' => 'Aafrika',
                        'route' => '#'
                    ],
                    [
                        'modifiers' => 'm-purple',
                        'title' => 'Põhja-Ameerika',
                        'route' => '#'
                    ]
                ]
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

                @include('component.content.forum.nav', [
                    'items' => [
                        [
                            'type' => 'button',
                            'title' => 'Otsi foorumist',
                            'route' => '#',
                            'modifiers' => 'm-secondary m-block m-shadow'
                        ],
                        [
                            'type' => 'button',
                            'title' => trans("content.$type.create.title"),
                            'route' => route('content.create', ['type' => $type]),
                            'modifiers' => 'm-secondary m-block m-shadow'
                        ]
                    ]
                ])

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
                                'title' => 'Tripikad räägivad'
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
                                'title' => 'Tripikad räägivad'
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

    <div class="r-forum__additional">

        <div class="r-forum__additional-wrap">

            <div class="r-block">

                <div class="r-block__header">

                    @include('component.title', [
                        'modifiers' => 'm-red',
                        'title' => 'Tripikad räägivad'
                    ])

                </div>

                <div class="r-forum__additional-column m-first">

                    @include('component.content.forum.nav', [
                        'items' => [
                            [
                                'title' => 'Üldfoorum',
                                'route' => '#',
                                'modifiers' => 'm-large m-block m-icon',
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'title' => 'Ost-müük',
                                'route' => '#',
                                'modifiers' => 'm-large m-block m-icon',
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'title' => 'Vaba teema',
                                'route' => '#',
                                'modifiers' => 'm-large m-block m-icon',
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'type' => 'button',
                                'title' => 'Otsi foorumist',
                                'route' => '#',
                                'modifiers' => 'm-secondary m-block m-shadow'
                            ],
                            [
                                'type' => 'button',
                                'title' => 'Alusta teemat',
                                'route' => '#',
                                'modifiers' => 'm-secondary m-block m-shadow'
                            ]
                        ]
                    ])

                </div>

                <div class="r-forum__additional-column m-last">

                    @include('component.content.forum.list', [
                        'items' => [
                            [
                                'topic' => 'Samui hotellid?',
                                'route' => '#',
                                'date' => 'Täna, 15:12',
                                'profile' => [
                                    'modifiers' => 'm-mini',
                                    'image' => \App\Image::getRandom()
                                ],
                                'badge' => [
                                    'modifiers' => 'm-inverted',
                                    'count' => 9
                                ],
                                'tags' => [
                                    [
                                        'title' => 'Inglismaa',
                                        'modifiers' => 'm-green',
                                        'route' => ''
                                    ],
                                    [
                                        'title' => 'London',
                                        'modifiers' => 'm-purple',
                                        'route' => ''
                                    ],
                                ]
                            ],
                            [
                                'topic' => 'Soodsalt inglismaal rongi/metroo/bussiga? Kus hindu vaadata?',
                                'route' => '#',
                                'date' => 'Täna, 12:17',
                                'profile' => [
                                    'modifiers' => 'm-mini',
                                    'image' => \App\Image::getRandom()
                                ],
                                'badge' => [
                                    'modifiers' => 'm-inverted',
                                    'count' => 4
                                ],
                                'tags' => [
                                    [
                                        'title' => 'Rongireis',
                                        'modifiers' => 'm-gray',
                                        'route' => ''
                                    ]
                                ]
                            ],
                            [
                                'topic' => 'Puhkuseosakud Tenerifel',
                                'route' => '#',
                                'date' => '10. detsember 2015',
                                'profile' => [
                                    'modifiers' => 'm-mini',
                                    'image' => \App\Image::getRandom()
                                ],
                                'badge' => [
                                    'modifiers' => 'm-inverted',
                                    'count' => 2
                                ],
                                'tags' => [
                                    [
                                        'title' => 'Tenerife',
                                        'modifiers' => 'm-red',
                                        'route' => ''
                                    ]
                                ]
                            ],
                            [
                                'topic' => 'Ischgl mäeolud-pilet ja majutus',
                                'route' => '#',
                                'date' => '11. detsember 2015',
                                'profile' => [
                                    'modifiers' => 'm-mini',
                                    'image' => \App\Image::getRandom()
                                ],
                                'badge' => [
                                    'modifiers' => '',
                                    'count' => 2
                                ],
                                'tags' => [
                                    [
                                        'title' => 'Tenerife',
                                        'modifiers' => 'm-red',
                                        'route' => ''
                                    ],
                                    [
                                        'title' => 'Rong',
                                        'modifiers' => 'm-gray',
                                        'route' => ''
                                    ],
                                    [
                                        'title' => 'Mäed',
                                        'modifiers' => 'm-gray',
                                        'route' => ''
                                    ]
                                ]
                            ]
                        ]
                    ])
                </div>
            </div>

            <div class="r-block">

                <div class="c-columns m-3-cols">

                    <div class="c-columns__item">

                        @include('component.card', [
                            'route' => '#',
                            'title' => 'Edasi-tagasi Riiast või Helsingist Bangkoki al 350 €',
                            'image' => \App\Image::getRandom()
                        ])
                    </div>

                    <div class="c-columns__item">

                        @include('component.card', [
                            'route' => '#',
                            'title' => 'Edasi-tagasi Riiast või Helsingist Bangkoki al 350 €',
                            'image' => \App\Image::getRandom()
                        ])
                    </div>

                    <div class="c-columns__item">

                        @include('component.card', [
                            'route' => '#',
                            'title' => 'Edasi-tagasi Riiast või Helsingist Bangkoki al 350 €',
                            'image' => \App\Image::getRandom()
                        ])
                    </div>

                </div>
            </div>

            <div class="r-block">

                <div class="r-block__header">
                    @include('component.title', [
                        'title' => 'Reisikaaslased',
                        'modifiers' => 'm-red'
                    ])
                </div>

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
    </div>

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






















