@extends('layouts.main')

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('masthead.search')

    @include('component.search',[
        'modifiers' => 'm-red',
        'placeholder' => ''
    ])

@stop

@section('masthead.bottom')

    @if($tags)
        @include('component.tags', [
            'items' => $tags
        ])
    @endif

@stop

@section('content')


        <div class="r-flights m-single">

    

    <div class="r-flights__masthead">

       @include('component.masthead', [
            'modifiers' => 'm-search m-alternative',
            'image' => \App\Image::getHeader()
        ])
    </div>

    <div class="r-flights__content-wrap">

        <div class="r-flights__content">

        @if($results && count($results)) 
            @foreach ($results as $content)
                @if ($active_search == 'destination')

                    @include('component.search.results.destination', [
                        'destination' => $content
                    ])

                @elseif ($active_search == 'user')

                    @include('component.search.results.user', [
                        'user' => $content
                    ])

                @else

                    @include('component.row', [
                        'profile' => [
                            'modifiers' => '',
                            'image' => $content->user->imagePreset(),
                            'route' => ($content->user->name != 'Tripi külastaja' ? route('user.show', [$content->user]) : false)
                        ],
                        'modifiers' => 'm-image',
                        'title' => $content->title,
                        'route' => route($content->type.'.show', [$content->slug]),
                        'text' => view('component.content.text', ['content' => $content]),
                    ])

                @endif          

            @endforeach

            @include('component.pagination.default', [
                    'collection' => $paginate
            ])

        @else
           {{ trans('search.results.noresults') }}
        @endif
        </div>

        <div class="r-flights__sidebar" style="padding-top:50px;">

            <div class="r-block m-small">

                @include('component.destination', [
                    'modifiers' => 'm-green',
                    'title' => 'Rio de Janeiro',
                    'title_route' => '/destination/4',
                    'subtitle' => 'Brasiilia',
                    'subtitle_route' => '#'
                ])

                @include('component.card', [
                    'modifiers' => 'm-green',
                    'route' => '#',
                    'title' => 'Edasi-tagasi Riiast või Helsingist Bangkoki al 350 €',
                    'image' => \App\Image::getRandom()
                ])

                @include('component.card', [
                    'modifiers' => 'm-green',
                    'route' => '#',
                    'title' => 'Air China Stockholmist Filipiinidele, Singapuri või Hongkongi al 285 €',
                    'image' => \App\Image::getRandom()
                ])

                <div class="r-block__inner">

                    <div class="r-block__header">

                        <div class="r-block__header-title">

                            @include('component.title', [
                                'modifiers' => 'm-green',
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
                                        'image' => \App\Image::getRandom(),
                                        'letter' => [
                                            'modifiers' => 'm-green m-small',
                                            'text' => 'D'
                                        ],
                                    ],
                                    'badge' => [
                                        'modifiers' => 'm-inverted m-green',
                                        'count' => 9
                                    ]
                                ],
                                [
                                    'topic' => 'Soodsalt inglismaal rongi/metroo/bussiga? Kus hindu vaadata?',
                                    'route' => '#',
                                    'profile' => [
                                        'modifiers' => 'm-mini',
                                        'image' => \App\Image::getRandom(),
                                        'letter' => [
                                            'modifiers' => 'm-green m-small',
                                            'text' => 'D'
                                        ],
                                    ],
                                    'badge' => [
                                        'modifiers' => 'm-inverted m-green',
                                        'count' => 4
                                    ]
                                ],
                                [
                                    'topic' => 'Puhkuseosakud Tenerifel',
                                    'route' => '#',
                                    'profile' => [
                                        'modifiers' => 'm-mini',
                                        'image' => \App\Image::getRandom(),
                                        'letter' => [
                                            'modifiers' => 'm-green m-small',
                                            'text' => 'D'
                                        ],
                                    ],
                                    'badge' => [
                                        'modifiers' => 'm-inverted m-green',
                                        'count' => 2
                                    ]
                                ],
                                [
                                    'topic' => 'Ischgl mäeolud-pilet ja majutus',
                                    'route' => '#',
                                    'profile' => [
                                        'modifiers' => 'm-mini',
                                        'image' => \App\Image::getRandom(),
                                        'letter' => [
                                            'modifiers' => 'm-green m-small',
                                            'text' => 'D'
                                        ],
                                    ],
                                    'badge' => [
                                        'modifiers' => 'm-green',
                                        'count' => 2
                                    ]
                                ]
                            ]
                        ])
                    </div>

                </div>
            </div>

            <div class="r-block m-small">

                @include('component.destination', [
                    'modifiers' => 'm-yellow',
                    'title' => 'Ho Chi Minh',
                    'title_route' => '/destination/4',
                    'subtitle' => 'Vietnam',
                    'subtitle_route' => '#'
                ])

                @include('component.destination', [
                    'modifiers' => 'm-blue',
                    'title' => 'Helsinki',
                    'title_route' => '/destination/4',
                    'subtitle' => 'Soome',
                    'subtitle_route' => '#'
                ])

                @include('component.destination', [
                    'modifiers' => 'm-red',
                    'title' => 'London',
                    'title_route' => '/destination/4',
                    'subtitle' => 'Inglismaa',
                    'subtitle_route' => '#'
                ])
            </div>

            <div class="r-block m-small">

                @include('component.promo', ['promo' => 'sidebar_small'])

            </div>

            <div class="r-block m-small">

                <div class="r-block__inner">

                    @include('component.about', [
                        'title' => 'Trip.ee on reisihuviliste kogukond, keda ühendab reisipisik ning huvi kaugete maade ja kultuuride vastu.',
                        'links' => [
                            [
                                'modifiers' => 'm-icon',
                                'title' => 'Loe lähemalt Trip.ee-st',
                                'route' => '#',
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'modifiers' => 'm-icon',
                                'title' => 'Trip.ee Facebookis',
                                'route' => '#',
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'modifiers' => 'm-icon',
                                'title' => 'Trip.ee Twitteris',
                                'route' => '#',
                                'icon' => 'icon-arrow-right'
                            ]
                        ],
                        'button' => [
                            'title' => 'Liitu Trip.ee-ga',
                            'route' => '#',
                            'modifiers' => 'm-block'
                        ]
                    ])

                </div>
            </div>

            <div class="r-block m-small">

                @include('component.promo', ['promo' => 'sidebar_small'])

            </div>

        </div>

    </div>

    <div class="r-flights__offers">

        <div class="r-flights__offers-wrap">

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
    </div>

    <div class="r-flights__travel-mates">

        <div class="r-flights__travel-mates-wrap">

            <div class="r-flights_travel-mates-title">

                @include('component.title', [
                    'title' => 'Reisikaaslased',
                    'modifiers' => 'm-green'
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
                        'letter' => [
                                'modifiers' => 'm-green m-small',
                                'text' => 'D'
                            ],
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
                        'letter' => [
                                'modifiers' => 'm-green m-small',
                                'text' => 'D'
                            ],
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
                        'letter' => [
                                'modifiers' => 'm-green m-small',
                                'text' => 'D'
                            ],
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

    <div class="r-flights__footer-promo">

        <div class="r-flights__footer-promo-wrap">

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