@extends('layouts.main')

@section('title')

    {{ trans("content.$type.index.title") }}

@stop

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('header1.image')

    @if($content->images())

        {{ $content->imagePreset('large') }}

    @endif

@stop

@section('content')

<div class="r-flights m-single">

    <div class="r-flights__map">

        <div class="r-flights__map-inner">

            @include('component.map', [
                'modifiers' => 'm-flights'
            ])

        </div>
    </div>

    <div class="r-flights__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-alternative',
            'subtitle' => 'Kõik pakkumised',
            'subtitle_route' => '/content/flight',
            'image' => \App\Image::getRandom()
        ])
    </div>

    <div class="r-flights__content-wrap">

        <div class="r-flights__content">

            <div class="r-flights__content-block">

                <div class="r-flights__content-header">

                    <div class="r-flights__content-header-title">

                        @include('component.title', [
                            'modifiers' => 'm-larger',
                            'title' => $content->title
                        ])

                    </div>

                    <div class="r-flights__content-header-meta">

                        @include('component.content.text', ['content' => $content])

                    </div>

                    @include('component.alert', [
                        'modifiers' => 'm-warning',
                        'text' => 'Pakkumine võib olla aegunud'
                    ])

                </div>

                <div class="c-body">

                    <p><strong>Hetkel on saadaval soodsad lennupiletid Stockholmist Tai ja Vietnami külastamiseks. Soodsaimad piletid (al 338 €) saadaval juhul, kui tagasilend valida Londonisse (mõnikümmend eurot kallimad piletid tagasilennuga Frankfurti). Lennupileteid soovitame otsida ja osta läbi <a href="#">momondo</a>.</strong></p>

                    <figure>
                        <img src="{{ \App\Image::getRandom() }}" alt="">
                        <figcaption>Näidispakkumine momondo veebilehelt</figcaption>
                    </figure>

                    <p>Bangkokist saab vägagi lihtsalt ühistranspordiga edasi kas Põhja-Taisse või Kambodžasse. Saab ühel reisil külastada nii Bangkoki kuulsat Khao San Roadi, Angkor Wati Siem Reapis kui ka eestlaste seas üsna populaarset rannakuurorti Sihanoukvilles Kambodžas. Tagasilend Euroopasse on Vietnami suurlinnast Ho Chi Minh City.</p>

                    <h2>Heading 2</h2>

                    <p>Soodsaima öömaja leiab kui kasutada hotellipakkumiste otsimiseks <a href="#">HotelsCombined.com</a>.</p>

                    <img src="{{ \App\Image::getRandom() }}" alt="">

                    <p><a href="#">Krisostomuse raamatupoel</a> on käimas kampaania, kus pakutakse Lonely Planet ning Rough Guide reisijuhte –25% soodsamalt! Sobiva reisijuhi vastavalt oma sihtkohale leiad <a href="#">SIIT</a>.</p>

                    <h3>Heading 3</h3>

                    <p>Bangkokist saab vägagi lihtsalt ühistranspordiga edasi kas Põhja-Taisse või Kambodžasse. Saab ühel reisil külastada nii Bangkoki kuulsat Khao San Roadi, Angkor Wati Siem Reapis kui ka eestlaste seas üsna populaarset rannakuurorti Sihanoukvilles Kambodžas. Tagasilend Euroopasse on Vietnami suurlinnast Ho Chi Minh City.</p>

                    <h4>Heading 4</h4>

                    <p>Bangkokist saab vägagi lihtsalt ühistranspordiga edasi kas Põhja-Taisse või Kambodžasse. Saab ühel reisil külastada nii Bangkoki kuulsat Khao San Roadi, Angkor Wati Siem Reapis kui ka eestlaste seas üsna populaarset rannakuurorti Sihanoukvilles Kambodžas. Tagasilend Euroopasse on Vietnami suurlinnast Ho Chi Minh City.</p>

                    @include('component.list', [
                        'modifiers' => 'm-dot m-green',
                        'items' => [
                            [
                                'title' => '05.11-21-11',
                                'route' => '#'
                            ],
                            [
                                'title' => '09.11-30-11 (jõulud)',
                                'route' => '#'
                            ],
                        ]
                    ])

                </div>

                {{--

                @include('component.row', ['body' => $content->body_filtered])
                @include('component.actions', ['actions' => $content->getActions()])
                @include('component.flags', ['flags' => $content->getFlags()])

                --}}

            </div>

            <div class="r-flights__content-block">

                <div class="r-flights__content-header">

                    <div class="r-flights__content-header-title">

                        @include('component.title', [
                            'modifiers' => 'm-large m-green',
                            'title' => 'Näidiskuupäevad'
                        ])

                    </div>
                </div>

                <div class="c-columns m-3-cols">

                    <div class="c-columns__item">

                        @include('component.title', [
                            'modifiers' => 'm-margin',
                            'title' => 'November 2015'
                        ])

                        @include('component.list', [
                            'items' => [
                                [
                                    'title' => '05.11-21-11',
                                    'route' => '#'
                                ],
                                [
                                    'title' => '09.11-30-11',
                                    'route' => '#'
                                ],
                                [
                                    'title' => '12.11-03.12',
                                    'route' => '#'
                                ],
                                [
                                    'title' => '19.11-10.12',
                                    'route' => '#'
                                ],
                            ]
                        ])

                    </div>

                    <div class="c-columns__item">

                        @include('component.title', [
                            'modifiers' => 'm-margin',
                            'title' => 'Detsember 2015'
                        ])

                        @include('component.list', [
                            'items' => [
                                [
                                    'title' => '05.11-21-11',
                                    'route' => '#'
                                ],
                                [
                                    'title' => '09.11-30-11 (jõulud)',
                                    'route' => '#'
                                ],
                            ]
                        ])

                    </div>

                    <div class="c-columns__item">

                        @include('component.title', [
                            'modifiers' => 'm-margin',
                            'title' => 'Jaanuar 2016'
                        ])

                        @include('component.list', [
                            'items' => [
                                [
                                    'title' => '05.11-21-11',
                                    'route' => '#'
                                ],
                                [
                                    'title' => '09.11-30-11',
                                    'route' => '#'
                                ],
                                [
                                    'title' => '12.11-03.12',
                                    'route' => '#'
                                ],
                                [
                                    'title' => '19.11-10.12',
                                    'route' => '#'
                                ],
                            ]
                        ])

                    </div>
                </div>

                <div class="c-body">

                    <p>Need on näidiskuupäevad. Soodsate hindadega lennupileteid leiab lendmiseks oktoobri lõpust aprillini! Otsi sobivad lennukuupäevad <a href="#">momondost</a>.</p>

                </div>

            </div>

            <div class="r-block">

                <div class="r-block__inner">

                    <div class="r-block__header">

                        <div class="r-block__header-title">

                            @include('component.title', [
                                'title' => 'Soovita pakkumist sõpradele',
                                'modifiers' => 'm-large m-green'
                            ])
                        </div>
                    </div>

                    <div class="r-block__body">

                        @include('component.facebook')
                    </div>

                </div>
            </div>

            <div class="r-block">

                @include('component.destination.helper', [
                    'modifiers' => 'm-green',
                    'title' => 'Rio De Janeiro',
                    'items' => [
                        [
                            'title' => 'Leia soodne majutus',
                            'route' => '',
                            'icon' => 'icon-house'
                        ],
                        [
                            'title' => 'Leia soodne rendiauto',
                            'route' => '',
                            'icon' => 'icon-car'
                        ],
                        [
                            'title' => 'Võrdle reisikindlustusi ja osta internetist',
                            'route' => '',
                            'icon' => 'icon-lock'
                        ],
                        [
                            'title' => 'Vaktsiinisoovitused sihtkohas',
                            'route' => '',
                            'icon' => 'icon-umbrella'
                        ]
                    ]
                ])
            </div>

            <div class="r-block m-mobile-hide">

                @include('component.promo', [
                    'modifiers' => 'm-body',
                    'route' => '#',
                    'image' => \App\Image::getRandom()
                ])
            </div>

            <div class="r-block">

                <div class="r-block__header">

                    <div class="r-block__header-title">

                        @include('component.title', [
                            'modifiers' => 'm-green',
                            'title' => 'Lennupakkumised'
                        ])
                    </div>
                </div>

                <div class="r-block__body">

                    @include('component.row', [
                        'icon' => 'icon-tickets',
                        'modifiers' => 'm-icon',
                        'title' => 'easyJeti lennupiletid Tallinnast Milanosse al 65 €',
                        'route' => '#',
                        'list' => [
                            [
                                'title' => 'Itaalia'
                            ],
                            [
                                'title' => 'Jaanuar – veebruar 2016 '
                            ],
                            [
                                'title' => 'Täna 12:32'
                            ]
                        ]
                    ])

                    @include('component.row', [
                        'icon' => 'icon-tickets',
                        'modifiers' => ' m-icon',
                        'title' => 'easyJeti lennupiletid Tallinnast Milanosse al 65 €',
                        'route' => '#',
                        'list' => [
                            [
                                'title' => 'Itaalia'
                            ],
                            [
                                'title' => 'Jaanuar – veebruar 2016 '
                            ],
                            [
                                'title' => 'Täna 12:32'
                            ]
                        ]
                    ])

                    @include('component.row', [
                        'icon' => 'icon-tickets',
                        'modifiers' => 'm-icon',
                        'title' => 'easyJeti lennupiletid Tallinnast Milanosse al 65 €',
                        'route' => '#',
                        'list' => [
                            [
                                'title' => 'Itaalia'
                            ],
                            [
                                'title' => 'Jaanuar – veebruar 2016 '
                            ],
                            [
                                'title' => 'Täna 12:32'
                            ]
                        ]
                    ])

                    @include('component.row', [
                        'icon' => 'icon-tickets',
                        'modifiers' => 'm-icon',
                        'title' => 'easyJeti lennupiletid Tallinnast Milanosse al 65 €',
                        'route' => '#',
                        'list' => [
                            [
                                'title' => 'Itaalia'
                            ],
                            [
                                'title' => 'Jaanuar – veebruar 2016 '
                            ],
                            [
                                'title' => 'Täna 12:32'
                            ]
                        ]
                    ])
                </div>

                <div class="r-block__footer">

                    @include('component.link', [
                        'modifiers' => 'm-icon m-right',
                        'title' => 'Vaata kõiki  sooduspakkumisi',
                        'route' => '#',
                        'icon' => 'icon-arrow-right'
                    ])
                </div>
            </div>

            <div class="r-block">

                <div class="r-block__header">

                    <div class="r-block__header-title">

                        @include('component.title', [
                            'title' => 'Kommentaarid',
                            'modifiers' => 'm-green'
                        ])
                    </div>
                </div>

                <div class="r-block__body">

                    @include('component.comment.index', ['comments' => $comments])

                    @include('component.content.forum.post',[
                        'profile' => [
                            'image' => \App\Image::getRandom(),
                            'title' => 'Charles Darwin',
                            'route' => '',
                            'modifiers' => 'm-full m-status',
                            'letter'=> [
                                'modifiers' => 'm-red m-small',
                                'text' => 'J'
                            ],
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
                            'image' => \App\Image::getRandom(),
                            'title' => 'Charles Darwin',
                            'letter'=> [
                                'modifiers' => 'm-red m-small',
                                'text' => 'J'
                            ],
                            'route' => '',
                            'modifiers' => 'm-full m-status',
                            'status' => [
                                'modifiers' => 'm-red',
                                'position' => '2'
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

                            <div class="r-block__header-title">

                                @include('component.title', [
                                    'title' => 'Lisa kommentaar',
                                    'modifiers' => 'm-large m-green'
                                ])
                            </div>
                        </div>

                        <div class="r-block__body">

                            @include('component.comment.create')
                        </div>
                    </div>
                </div>

            @endif

        </div>

        <div class="r-flights__sidebar">

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

                        <div class="r-block__header-title m-flex">

                            @include('component.title', [
                                'modifiers' => 'm-green',
                                'title' => 'Tripikad räägivad'
                            ])

                            <div class="r-block__header-link">

                                @include('component.link', [
                                    'modifiers' => 'm-icon m-small',
                                    'title' => 'Brasiilia foorum',
                                    'route' => '#',
                                    'icon' => 'icon-arrow-right'
                                ])
                            </div>
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

            <div class="r-block m-small m-mobile-hide">

                @include('component.promo', [
                    'modifiers' => 'm-sidebar-small',
                    'route' => '',
                    'image' => \App\Image::getRandom()
                ])
            </div>

            <div class="r-block m-small">

                <div class="r-block__inner">

                    @include('component.about', [
                        'title' => 'Trip.ee on reisihuviliste kogukond, keda ühendab reisipisik ning huvi kaugete maade ja kultuuride vastu.',
                        'text' => 'Hoiame headel pakkumistel igapäevaselt silma peal ning jagame neid kõigi huvilistega.',
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

            <div class="r-block m-small m-mobile-hide">

                @include('component.promo', [
                    'modifiers' => 'm-sidebar-small',
                    'route' => '',
                    'image' => \App\Image::getRandom()
                ])
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

    <div class="r-flights__travelmates">

        <div class="r-flights__travelmates-wrap">

            <div class="r-flights__travelmates-title">

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

        </div>

    </div>

    <div class="r-flights__footer-promo">

        <div class="r-flights__footer-promo-wrap">

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
