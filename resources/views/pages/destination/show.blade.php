@extends('layouts.main')

@section('title')

    {{ $destination->name }}

@stop

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('masthead.nav')

    @include('component.masthead.nav', [
        'nav_previous_title' => $previous_destination->name,
        'nav_previous_route' => route('destination.show', [$previous_destination]),
        'nav_next_title' => $next_destination->name,
        'nav_next_route' => route('destination.show', [$next_destination]),
        'modifiers' => 'm-yellow'
    ])

@stop

@section('content')

<div class="r-destination">

    <div class="r-destination__extra m-yellow">

        @if (\Auth::user())

            @include('component.destination.extra', [
                'items' => [
                    [
                        'icon' => (count($destination->usersHaveBeen()->where('user_id', \Auth::user()->id))
                            ?
                                'icon-pin-filled'
                            :
                                'icon-pin'
                        ),
                        'title' => $destination->usersHaveBeen()->count(),
                        'modifiers' => (count($destination->usersHaveBeen()->where('user_id', \Auth::user()->id))
                            ?
                                'm-active'
                            :
                                ''
                        ),
                        'text' => (count($destination->usersHaveBeen()->where('user_id', \Auth::user()->id))
                            ?
                                trans('destination.show.user.button.havenotbeen')
                            :
                                trans('destination.show.user.button.havebeen')
                        ),
                        'route' => route('flag.toggle', ['destination', $destination, 'havebeen'])
                    ],
                    [
                        'icon' => (count($destination->usersWantsToGo()->where('user_id', \Auth::user()->id))
                            ?
                                'icon-star-filled'
                            :
                                'icon-star'
                        ),
                        'title' => $destination->usersWantsToGo()->count(),
                        'modifiers' => (count($destination->usersWantsToGo()->where('user_id', \Auth::user()->id))
                            ?
                                'm-active'
                            :
                                ''
                        ),
                        'text' => (count($destination->usersWantsToGo()->where('user_id', \Auth::user()->id))
                            ?
                                trans('destination.show.user.button.dontwanttogo')
                            :
                                trans('destination.show.user.button.wanttogo')
                        ),
                        'route' => route('flag.toggle', ['destination', $destination, 'wantstogo'])
                    ]
                ]
            ])

        @else

            @include('component.destination.extra', [
                'items' => [
                    [
                        'icon' => 'icon-pin',
                        'title' => $destination->usersHaveBeen()->count(),
                        'text' => 'Have been there',
                        'route' => ''
                    ],
                    [
                        'icon' => 'icon-star',
                        'title' => $destination->usersWantsToGo()->count(),
                        'text' => 'Want to go there',
                        'route' => ''
                    ]
                ]
            ])

        @endif
    </div>

    <div class="r-destination__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-alternative',
            'subtitle' => (isset($parent_destination) ? $parent_destination->name : null),
            'subtitle_route' => (isset($parent_destination) ? route('destination.show', [$parent_destination]) : null),
            'image' =>
                (isset($features['photos']) && count($features['photos']['contents'])
                    ?
                        $features['photos']['contents']->random(1)->imagePreset()
                    :
                        \App\Image::getRandom()
                )
        ])
    </div>

    <div class="r-destination__about m-yellow">

        <div class="r-destination__about-wrap">

            @if (isset($features['flights']) && count($features['flights']['contents']))

                <div class="r-destination__about-column m-first">

                    <div class="r-destination__title-block m-white m-distribute">

                        @include('component.title', [
                            'modifiers' => 'm-yellow',
                            'title' => trans('destination.show.good.offer')
                        ])

                        @include('component.link', [
                            'modifiers' => 'm-tiny',
                            'title' => trans('destination.show.link.view.all'),
                            'route' => route('content.index', ['flights'])
                        ])
                    </div>

                    @foreach ($features['flights']['contents'] as $flight)

                        @include('component.card', [
                            'modifiers' => 'm-yellow m-small',
                            'route' => route('content.show', [$flight->type, $flight]),
                            'title' => str_limit($flight->title, 50).' '.$flight->price.' '.config('site.currency.symbol'),
                            'image' => $flight->imagePreset(),
                        ])

                    @endforeach

                </div>

            @endif

            <div class="r-destination__about-column
            @if (isset($features['flights']) && count($features['flights']['contents']))
                m-last
            @endif
            ">

                <div class="c-columns {{ (isset($features['flights']) && count($features['flights']['contents']) ? 'm-1-cols' : 'm-2-cols m-space') }}">

                    <div class="c-columns__item">



                    </div>

                    <div class="c-columns__item">



                    </div>
                </div>
            </div>

            <div class="r-destination__about-map">

                @include('component.map', [
                    'modifiers' => 'm-destination',
                    'map_top' => '53%',
                    'map_left' => '50%'
                ])
            </div>
        </div>
    </div>

    <div class="r-destination__content">

    @if (isset($features['flights2']) && count($features['flights2']['contents']))

        <div class="r-destination__content-wrap m-padding">

    @else

        <div class="r-destination__content-wrap">

    @endif

            @if ((isset($popular_destinations) && count($popular_destinations)) || (isset($features['forum_posts']) && count($features['forum_posts']['contents'])))

                <div class="r-destination__content-about">

                    <div class="r-destination__content-about-column m-first">

                        @include('component.promo', [
                            'modifiers' => 'm-sidebar-small',
                            'route' => '#',
                            'image' => \App\Image::getRandom()
                        ])

                    </div>

                    <div class="r-destination__content-about-column m-middle">

                        @if (isset($features['forum_posts']) && count($features['forum_posts']['contents']))

                            <div class="r-destination__content-title">

                                @include('component.title', [
                                    'modifiers' => 'm-yellow',
                                    'title' => trans('destination.show.forum.title')
                                ])

                            </div>

                            @include('component.content.forum.list', [
                                'modifiers' => 'm-compact',
                                'items' => $features['forum_posts']['contents']->transform(function($forum) {
                                    return [
                                        'topic' => $forum->title,
                                        'route' => route('content.show', [$forum->type, $forum]),
                                        'profile' => [
                                            'modifiers' => 'm-mini',
                                            'image' => $forum->user->imagePreset(),
                                            'letter'=> [
                                                'modifiers' => 'm-red',
                                                'text' => 'J'
                                            ],
                                        ],
                                        'badge' => [
                                            'modifiers' => 'm-inverted',
                                            'count' => $forum->comments->count()
                                        ]
                                    ];
                                })
                            ])
                        @else

                            <p>&nbsp;</p>

                        @endif

                    </div>

                    <div class="r-destination__content-about-column m-last">

                        @if (isset($popular_destinations) && count($popular_destinations))

                            <div class="r-destination__content-title">

                                @include('component.title', [
                                    'modifiers' => 'm-yellow',
                                    'title' => trans('destination.show.popular.title', [
                                        'destination' => $root_destination->name
                                    ])
                                ])

                            </div>

                            @include('component.list', [
                                'modifiers' => 'm-dot m-yellow',
                                'items' => $popular_destinations->transform(function($destination) {
                                    return [
                                        'title' => $destination->name,
                                        'route' => route('destination.show', [$destination])
                                    ];
                                })
                            ])

                        @else

                            <p>&nbsp;</p>

                        @endif

                    </div>

                </div>

            @endif

            @if (isset($features['photos']) && count($features['photos']['contents']))

                <div class="r-destination__content-gallery">

                    <div class="r-destination__gallery-wrap">

                        <div class="r-destination__gallery-title">

                            <div class="r-destination__gallery-title-wrap">

                                @include('component.title', [
                                    'modifiers' => 'm-yellow',
                                    'title' => 'Viimati lisatud pildid'
                                ])
                            </div>
                        </div>

                        {{--

                        @include('component.gallery', [
                            'modal' => [
                                'modifiers' => 'm-yellow',
                            ],
                            'items' => $features['photos']['contents']->transform(function($photo) {
                                return [
                                    'image' => $photo->imagePreset(),
                                    'route' => route('content.show', [$photo->type, $photo]),
                                    'alt' => $photo->title,
                                ];
                            })
                        ])

                        --}}

                        @include('component.gallery', [
                            'modal' => [
                                'modifiers' => 'm-yellow',
                            ],
                            'items' => [
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => 'Random name or title',
                                    'tags' => [
                                        [
                                            'title' => 'Malta',
                                            'modifiers' => 'm-orange',
                                            'route' => '#'
                                        ],
                                        [
                                            'title' => 'Europe',
                                            'modifiers' => 'm-red',
                                            'route' => '#'
                                        ],
                                        [
                                            'title' => 'Suusapuhkus',
                                            'modifiers' => 'm-gray',
                                            'route' => '#'
                                        ]
                                    ]
                                ],
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => '',
                                    'tags' => [
                                        [
                                            'title' => 'Valetta',
                                            'modifiers' => 'm-blue',
                                            'route' => '#'
                                        ]
                                    ]
                                ],
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => '',
                                ],
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => 'Random longer name or very long title and something else which is long',
                                ],
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => '',
                                ],
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => '',
                                ],
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => '',
                                ],
                                [
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'alt' => '',
                                ],
                            ]
                        ])

                    </div>

                </div>

            @endif

            <div class="r-destination__content-news">

                <div class="r-destination__content-news-wrap">

                    <div class="r-destination__content-news-column m-first">

                    @if (isset($features['news']) && count($features['news']['contents']))

                        <div class="r-destination__content-title">

                            @include('component.title', [
                                'modifiers' => 'm-yellow',
                                'title' => trans('destination.show.news.title')
                            ])
                        </div>

                        <div class="r-destination__content-news-block">

                            <div class="c-columns m-2-cols m-space">

                                <div class="c-columns__item">

                                    @include('component.news', [
                                        'title' => 'Emirates kompab piire – lennukisse mahutatakse 615 reisijat',
                                        'modifiers' => 'm-smaller',
                                        'route' => '#',
                                        'date' => '',
                                        'image' => \App\Image::getRandom()
                                    ])
                                </div>

                                <div class="c-columns__item">

                                    @include('component.news', [
                                        'title' => 'Tuhande saare järv Hiinas',
                                        'modifiers' => 'm-smaller',
                                        'route' => '#',
                                        'date' => '',
                                        'image' => \App\Image::getRandom()
                                    ])
                                </div>

                                <div class="c-columns__item">

                                    @include('component.news', [
                                        'title' => 'EasyJet esitles uusi tehnikat täis vorme',
                                        'modifiers' => 'm-smaller',
                                        'route' => '#',
                                        'date' => '',
                                        'image' => \App\Image::getRandom()
                                    ])
                                </div>

                                <div class="c-columns__item">

                                    @include('component.news', [
                                        'title' => 'Egiptuse turismist - natuke laiemalt',
                                        'modifiers' => 'm-smaller',
                                        'route' => '#',
                                        'date' => '',
                                        'image' => \App\Image::getRandom()
                                    ])
                                </div>
                            </div>
                        </div>

                    @endif

                        <div class="r-block m-mobile-hide">

                            @include('component.promo', [
                                'modifiers' => 'm-body',
                                'route' => '#',
                                'image' => \App\Image::getRandom()
                            ])
                        </div>

                        <div class="r-destination__content-title">

                            @include('component.title', [
                                'modifiers' => 'm-yellow',
                                'title' => 'Reisikirjad'
                            ])
                        </div>

                        <div class="c-columns m-2-cols m-space">

                            <div class="c-columns__item">

                                @include('component.blog', [
                                    'modifiers' => 'm-mobile-margin',
                                    'title' => 'Minu Malta – jutustusi kuuajaliselt ringreisilt',
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'profile' => [
                                        'route' => '#',
                                        'title' => 'Mari Maasikas',
                                        'image' => \App\Image::getRandom()
                                    ]
                                ])
                            </div>

                            <div class="c-columns__item">

                                @include('component.blog', [
                                    'title' => 'Minu Malta – jutustusi kuuajaliselt ringreisilt',
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'profile' => [
                                        'route' => '#',
                                        'title' => 'Mari Maasikas',
                                        'image' => \App\Image::getRandom()
                                    ]
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="r-destination__content-news-column m-last">

                        <div class="r-block">

                            @include('component.promo', [
                                'modifiers' => 'm-sidebar-large',
                                'route' => '#',
                                'image' => \App\Image::getRandom()
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (isset($features['flights2']) && count($features['flights2']['contents']))

    <div class="r-destination__flights">

        <div class="r-destination__flights-wrap">

            <div class="c-columns m-3-cols">

                <div class="c-columns__item">

                    @include('component.destination', [
                        'modifiers' => 'm-purple',
                        'title' => 'Tai',
                        'title_route' => '/destination/335',
                        'subtitle' => 'Aasia',
                        'subtitle_route' => '/destination/2'
                    ])

                    @include('component.card', [
                        'modifiers' => 'm-purple',
                        'route' => '',
                        'title' => 'Edasi-tagasi Riiast või Helsingist Bangkoki al 350 €',
                        'image' => \App\Image::getRandom(),
                    ])
                </div>

                <div class="c-columns__item">

                    @include('component.destination', [
                        'modifiers' => 'm-yellow',
                        'title' => 'Saksamaa',
                        'title_route' => '/destination/326',
                        'subtitle' => 'Euroopa',
                        'subtitle_route' => '/destination/1'
                    ])

                    @include('component.card', [
                        'modifiers' => 'm-yellow',
                        'route' => '',
                        'title' => 'Kevadpuhkus Amsterdamis al 121 €',
                        'image' => \App\Image::getRandom(),
                    ])
                </div>

                <div class="c-columns__item">

                    @include('component.destination', [
                        'modifiers' => 'm-red',
                        'title' => 'New York',
                        'title_route' => '/destination/451',
                        'subtitle' => 'Põhja-Ameerika',
                        'subtitle_route' => '/destination/5'
                    ])

                    @include('component.card', [
                        'modifiers' => 'm-red',
                        'route' => '',
                        'title' => 'Edasi-tagasi lennud New Yorki al 449 €',
                        'image' => \App\Image::getRandom(),
                    ])
                </div>
            </div>
        </div>
    </div>

    @endif

    @if (isset($features['travel_mates']) && count($features['travel_mates']['contents']))

        <div class="r-destination__travelmates">

            <div class="r-destination__travelmates-wrap">

                <div class="r-destination__content-title">

                    @include('component.title', [
                        'title' => trans('frontpage.index.travelmate.title'),
                        'modifiers' => 'm-yellow'
                    ])

                </div>

                @include('component.travelmate.list', [
                    'modifiers' => 'm-3col',
                    'items' => [
                        [
                            'modifiers' => 'm-small',
                            'image' =>  \App\Image::getRandom(),
                            'letter'=> [
                                'modifiers' => 'm-red',
                                'text' => 'J'
                            ],
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
                            'letter'=> [
                                'modifiers' => 'm-red',
                                'text' => 'J'
                            ],
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
                            'letter'=> [
                                'modifiers' => 'm-red',
                                'text' => 'J'
                            ],
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

                {{--

                1. NEW updated travelmate list

                <div class="c-columns m-{{ count($features['travel_mates']['contents']) }}-cols">

                    @foreach($features['travel_mates']['contents'] as $travel_mate)

                        <div class="c-columns__item">

                            @include('component.profile', [
                                'title' => $travel_mate->user->name,
                                'age' => $travel_mate->user->age,
                                'interests' => $travel_mate->title,
                                'route' => route('content.show', [$travel_mate->type, $travel_mate]),
                                'image' => $travel_mate->user->imagePreset()
                            ])

                        </div>

                    @endforeach

                </div>

                --}}

            </div>

        </div>

    @endif

    <div class="r-destination__footer-promo">

        <div class="r-destination__footer-promo-wrap">

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
