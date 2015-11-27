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

    <div class="r-destination__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-alternative',
            'subtitle' => (isset($parent_destination) ? $parent_destination->name : null),
            'subtitle_route' => (isset($parent_destination) ? route('destination.show', [$parent_destination]) : null),
            'image' => \App\Image::getRandom()
        ])

    </div>

    <div class="r-destination__about m-yellow">

        <div class="r-destination__about-wrap">

            <div class="r-destination__about-column m-first">

                <div class="r-destination__title-block m-white m-distribute">

                    @include('component.title', [
                        'modifiers' => 'm-yellow',
                        'title' => 'Head pakkumised'
                    ])

                    @include('component.link', [
                        'modifiers' => 'm-tiny',
                        'title' => 'Kõik pakkumised &rsaquo;',
                        'route' => '#'
                    ])

                </div>

                @include('component.card', [
                    'modifiers' => 'm-yellow m-small',
                    'route' => '#',
                    'title' => 'Edasi-tagasi Riiast või Helsingist Bangkoki al 350 €',
                    'image' => \App\Image::getRandom(),
                ])

                @include('component.card', [
                    'modifiers' => 'm-yellow m-small',
                    'route' => '#',
                    'title' => 'Edasi-tagasi Riiast või Helsingist Bangkoki al 350 €',
                    'image' => \App\Image::getRandom(),
                ])

            </div>

            <div class="r-destination__about-column m-last">

                @include('component.destination.info',[
                    'modifiers' => 'm-yellow',
                    'text' => 'Malta on tihedalt asustatud saareriik Vahemeres, mis koosneb 3 asustatud ja neljast asustamata saartest',
                    'wiki_route' => '#',
                    'definitions' => [
                        [
                            'term' => 'Rahvaarv',
                            'definition' => '417 600 in'
                        ],
                        [
                            'term' => 'Pindala',
                            'definition' => '316 km²'
                        ],
                        [
                            'term' => 'Valuuta',
                            'definition' => 'Euro (€, EUR)'
                        ],
                        [
                            'term' => 'Aeg',
                            'definition' => '10:23(+1h)'
                        ],
                    ]
                ])

            </div>

            <div class="r-destination__about-map">

                @include('component.map', [
                    'map_top' => '53%',
                    'map_left' => '50%'
                ])

            </div>
        </div>
    </div>

    <div class="r-destination__content">

        <div class="r-destination__content-wrap">

            <div class="r-destination__content-about">

                <div class="r-destination__content-about-column m-first">

                    @include('component.promo', [
                        'route' => '#',
                        'image' => \App\Image::getRandom()
                    ])
                </div>

                <div class="r-destination__content-about-column m-middle">

                    <div class="r-destination__content-title">

                        @include('component.title', [
                            'modifiers' => 'm-yellow',
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
                                    'modifiers' => 'm-inverted',
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
                                    'modifiers' => 'm-inverted',
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
                                    'modifiers' => 'm-inverted',
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
                                    'modifiers' => '',
                                    'count' => 2
                                ]
                            ]
                        ]
                    ])

                </div>

                <div class="r-destination__content-about-column m-last">

                    <div class="r-destination__content-title">

                        @include('component.title', [
                            'modifiers' => 'm-yellow',
                            'title' => 'Populaarsed sihtkohad'
                        ])
                    </div>

                    @include('component.list', [
                        'modifiers' => 'm-dot m-yellow',
                        'items' => [
                            [
                                'title' => 'Valletta',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Cottonera',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Hagar Qim and Mnajdra',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Mellieha',
                                'route' => '#'
                            ],
                        ]
                    ])

                </div>
            </div>

            <div class="r-destination__content-gallery">

                <div class="r-destination__gallery-wrap">

                    @include('component.gallery', [
                        'items' => [
                            [
                                'image' => \App\Image::getRandom(),
                                'route' => '#',
                                'alt' => 'Pilt 1'
                            ],
                            [
                                'image' => \App\Image::getRandom(),
                                'route' => '#',
                                'alt' => 'Pilt 2'
                            ],
                            [
                                'image' => \App\Image::getRandom(),
                                'route' => '#',
                                'alt' => 'Pilt 3'
                            ],
                            [
                                'image' => \App\Image::getRandom(),
                                'route' => '#',
                                'alt' => 'Pilt 4'
                            ],
                            [
                                'image' => \App\Image::getRandom(),
                                'route' => '#',
                                'alt' => 'Pilt 5'
                            ],
                            [
                                'image' => \App\Image::getRandom(),
                                'route' => '#',
                                'alt' => 'Pilt 6'
                            ],
                            [
                                'image' => \App\Image::getRandom(),
                                'route' => '#',
                                'alt' => 'Pilt 7'
                            ],
                            [
                                'image' => \App\Image::getRandom(),
                                'route' => '#',
                                'alt' => 'Pilt 8'
                            ],
                        ]
                    ])

                </div>
            </div>

            <div class="r-destination__content-news">

                <div class="r-destination__content-news-wrap">

                    <div class="r-destination__content-news-column m-first">

                        <div class="r-destination__content-title">

                            @include('component.title', [
                                'modifiers' => 'm-yellow',
                                'title' => 'Uudised'
                            ])
                        </div>

                        @include('component.list', [
                            'modifiers' => 'm-large',
                            'items' => [
                                [
                                    'title' => 'Air Canada tunnistab veahinnaga pileteid!',
                                    'route' => '#',
                                    'text' => '23. oktoober'
                                ],
                                [
                                    'title' => 'Kas ametlikult maailma parim lennufirma on parim ka reisijate arvates?',
                                    'route' => '#',
                                    'text' => '19. oktoober'
                                ],
                                [
                                    'title' => 'Reisiidee: maailma suurim hindu tempel Akshardham Delhis',
                                    'route' => '#',
                                    'text' => '11. oktoober'
                                ]
                            ]
                        ])

                    </div>

                    <div class="r-destination__content-news-column m-last">

                        <div class="r-destination__content-title">

                            @include('component.title', [
                                'modifiers' => 'm-yellow',
                                'title' => 'Reisikirjad'
                            ])
                        </div>

                        @include('component.blog', [
                            'title' => 'Minu Aafrika – jutustusi kuuajaselt ringreisilt',
                            'route' => '#',
                            'image' => \App\Image::getRandom(),
                            'profile' => [
                                'route' => '#profile',
                                'title' => 'Mari Maasikas',
                                'image' => \App\Image::getRandom()
                            ]
                        ])

                    </div>
                </div>
            </div>

            <div class="r-destination__content-travel-mates">

                <div class="r-destination__content-travel-mates-wrap">

                    <div class="r-destination__content-title">

                        @include('component.title', [
                            'title' => 'Reisikaaslased',
                            'modifiers' => 'm-yellow'
                        ])
                    </div>

                    <div class="c-columns m-4-cols">

                        <div class="c-columns__item">

                            @include('component.profile', [
                                'title' => 'Jaanus Jaaniuss',
                                'age' => '22',
                                'interests' => 'Itaalia',
                                'route' => '',
                                'image' => \App\Image::getRandom()
                            ])
                        </div>

                        <div class="c-columns__item">

                            @include('component.profile', [
                                'title' => 'Mari Maasikas',
                                'age' => '29',
                                'interests' => 'Itaalia, Kreeka',
                                'route' => '',
                                'image' => \App\Image::getRandom()
                            ])
                        </div>

                        <div class="c-columns__item">

                            @include('component.profile', [
                                'title' => 'Inga Ingel',
                                'age' => '32',
                                'interests' => 'Kreeka',
                                'route' => '',
                                'image' => \App\Image::getRandom()
                            ])
                        </div>

                        <div class="c-columns__item">

                            @include('component.profile', [
                                'title' => 'Silver Siil',
                                'age' => '19',
                                'interests' => 'Aasia, Euroopa',
                                'route' => '',
                                'image' => \App\Image::getRandom()
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <div class="r-destination__content-flights">

                <div class="r-destination__content-flights-wrap">

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

        </div>
    </div>

    <div class="r-destination__footer-promo">

        <div class="r-destination__footer-promo-wrap">

            @include('component.promo', [
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
