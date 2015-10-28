@extends('layouts.main')

@section('masthead.search')

    @include('component.search',[
        'modifiers' => 'm-red',
        'placeholder' => 'Where do you want to go today?'
    ])

@stop

@section('content')

<div class="r-home">

    <div class="r-home__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-search'
        ])

    </div>

    <div class="r-home__destinations">

        <div class="r-home__destinations-wrap">

            <div class="c-columns m-3-cols">

                <div class="c-columns__item">

                    @include('component.destination', [
                        'modifiers' => 'm-yellow',
                        'title' => 'Aafrika',
                        'title_route' => '/destination/4',
                        'subtitle' => 'Itaalia',
                        'subtitle_route' => '#'
                    ])

                    @include('component.card', [
                        'modifiers' => 'm-yellow',
                        'route' => '#',
                        'title' => 'Edasi-tagasi Riiast või Helsingist Bangkoki al 350 €',
                        'image' => \App\Image::getRandom(),
                    ])

                </div>

                <div class="c-columns__item">

                    @include('component.destination', [
                        'modifiers' => 'm-red',
                        'title' => 'Põhja-Ameerika',
                        'title_route' => '/destination/5',
                        'subtitle' => 'Itaalia',
                        'subtitle_route' => '#'
                    ])

                    @include('component.card', [
                        'modifiers' => 'm-red',
                        'route' => '#',
                        'title' => 'Edasi-tagasi Riiast või Helsingist Bangkoki al 350 €',
                        'image' => \App\Image::getRandom(),
                    ])

                </div>

                <div class="c-columns__item">

                    @include('component.destination', [
                        'modifiers' => 'm-green',
                        'title' => 'Kesk-Ameerika',
                        'title_route' => '/destination/6',
                        'subtitle' => 'Itaalia',
                        'subtitle_route' => '#'
                    ])

                    @include('component.card', [
                        'modifiers' => 'm-green',
                        'route' => '#',
                        'title' => 'Edasi-tagasi Riiast Bangkoki al 350 €',
                        'image' => \App\Image::getRandom(),
                    ])

                </div>
            </div>
        </div>
    </div>

    <div class="r-home__about">

        <div class="r-home__about-wrap">

            @include('component.about', [
                'modifiers' => 'm-wide',
                'title' => 'Trip.ee on reisihuviliste kogukond, keda ühendab reisipisik ning huvi kaugete maade ja kultuuride vastu.',
                'link' => [
                    'title' => 'Loe lähemalt Trip.ee-st ›',
                    'route' => '#',
                ],
                'button' => [
                    'title' => 'Liitu Trip.ee-ga',
                    'route' => '#',
                    'modifiers' => 'm-block'
                ]
            ])

        </div>
    </div>

    <div class="r-home__forum">

        <div class="r-home__forum-wrap">

            <div class="r-home__forum-title">

                @include('component.title', [
                    'modifiers' => 'm-red',
                    'title' => 'Tripikad räägivad'
                ])

            </div>

            <div class="r-home__forum-column m-first">

                @include('component.link', [
                    'modifiers' => 'm-large m-block',
                    'title' => 'Üldfoorum',
                    'route' => ''
                ])

                @include('component.link', [
                    'modifiers' => 'm-large m-block',
                    'title' => 'Ost-müük',
                    'route' => ''
                ])

                @include('component.link', [
                    'modifiers' => 'm-large m-block',
                    'title' => 'Vaba teema',
                    'route' => ''
                ])

                @include('component.button', [
                    'modifiers' => 'm-secondary m-block',
                    'title' => 'Otsi foorumist',
                    'route' => ''
                ])

                @include('component.button', [
                    'modifiers' => 'm-secondary m-block',
                    'title' => 'Alusta teemat',
                    'route' => ''
                ])

            </div>

            <div class="r-home__forum-column m-last">

                @include('component.content.forum.list', [
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
                                    'modifiers' => 'm-orange',
                                    'route' => ''
                                ]
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
                                    'modifiers' => 'm-green',
                                    'route' => ''
                                ],
                                [
                                    'title' => 'Mäed',
                                    'modifiers' => 'm-blue',
                                    'route' => ''
                                ]
                            ]

                        ]
                    ]
                ])
            </div>
        </div>
    </div>

    <div class="r-home__news">

        <div class="r-home__news-wrap">

            <div class="r-home__news-column m-first">

                @include('component.promo', [
                    'route' => '',
                    'image' => \App\Image::getRandom()
                ])

            </div>

            <div class="r-home__news-column m-last">

                <div class="r-home__news-title">

                    @include('component.title', [
                        'modifiers' => 'm-red',
                        'title' => 'Uudised'
                    ])

                </div>

                <div class="r-home__news-block-wrap">

                    <div class="r-home__news-block m-first">

                        @include('component.news', [
                            'title' => 'Euroopa Kohus otsustas – lennuki tehniline rike ei päästa hüvitise maksmisest',
                            'route' => '',
                            'date' => \Carbon\Carbon::now(),
                            'image' => \App\Image::getRandom()
                        ])

                    </div>

                    <div class="r-home__news-block m-last">

                        @include('component.news', [
                            'modifiers' => 'm-small',
                            'title' => 'Suur valuutaülevaade – kuhu tasub just praegu reisida',
                            'route' => '',
                            'date' => \Carbon\Carbon::now(),
                            'image' => \App\Image::getRandom()
                        ])

                    </div>
                </div>

                @include('component.list', [
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
                        ],
                        [
                            'title' => 'Reisiidee: Longshengi riisiterrassid',
                            'route' => '#',
                            'text' => '7. oktoober'
                        ]
                    ]
                ])

                @include('component.link', [
                    'title' => 'Kõik uudised &rsaquo;',
                    'route' => ''
                ])

            </div>
        </div>
    </div>

    <div class="r-home__travel">

        <div class="r-home__travel-wrap">

            <div class="r-home__travel-column m-first">

                <div class="r-home__travel-title">

                    @include('component.title', [
                        'modifiers' => 'm-red',
                        'title' => 'Lennupakkumised'
                    ])

                </div>

                @include('component.row', [
                    'icon' => 'icon-offer',
                    'modifiers' => 'm-blue m-icon',
                    'title' => 'easyJeti lennupiletid Tallinnast Milanosse al 65 €',
                    'route' => '#',
                    'text' => 'Jaanuar – veebruar 2016   /   Täna 12:32'
                ])
                @include('component.row', [
                    'icon' => 'icon-offer',
                    'modifiers' => 'm-yellow m-icon',
                    'title' => 'Edasi–tagasi riiast või Helsingist Bangkoki al 350 €',
                    'route' => '#',
                    'text' => 'Detsember 2015 – jaanuar 2016   /   Täna 9:11'
                ])
                @include('component.row', [
                    'icon' => 'icon-offer',
                    'modifiers' => 'm-green m-icon',
                    'title' => 'Reis Brasiilias: Tallinn–Recife/Salvador–Tallinn al 402 €',
                    'route' => '#',
                    'text' => 'Jaanuar – veebruar 2016   /   Eile 14:42'
                ])
                @include('component.row', [
                    'icon' => 'icon-offer',
                    'modifiers' => 'm-icon m-red',
                    'title' => 'Lennupiletid Helsingist Singapuri al 456 €',
                    'route' => '#',
                    'text' => 'Veebruar 2016   /   Eile 14:42'
                ])

                @include('component.link', [
                    'title' => 'Vaata kõiki sooduspakkumisi &rsaquo;',
                    'route' => ''
                ])

            </div>

            <div class="r-home__travel-column m-last">

                <div class="r-home__travel-title">

                    @include('component.title', [
                        'modifiers' => 'm-red',
                        'title' => 'Reisikirjad'
                    ])

                </div>

                @include('component.blog', [
                    'title' => 'Minu Aafrika – jutustusi kuuajaselt ringreisilt',
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

    <div class="r-home__gallery">

        <div class="r-home__gallery-wrap">

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
                    ]
                ]
            ])
        </div>
    </div>

    <div class="r-home__travel-mates">

        <div class="r-home__travel-mates-wrap">

            <div class="r-home__travel-mates-title">

                @include('component.title', [
                    'title' => 'Reisikaaslased',
                    'modifiers' => 'm-red'
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

    <div class="r-home__footer-promo">

        <div class="r-home__footer-promo-wrap">

            @include('component.promo', [
                'route' => '#',
                'image' => \App\Image::getRandom()
            ])

        </div>
    </div>

</div>

@stop
