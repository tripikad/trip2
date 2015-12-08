@extends('layouts.main')

@section('title')

    {{ trans("content.$type.index.title") }}

@stop

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('masthead.bottom')

    @include('component.tags', [
        'items' => [
            [
                'modifiers' => 'm-green',
                'route' => '#',
                'title' => 'Soojale maale'
            ],
            [
                'modifiers' => 'm-green',
                'route' => '#',
                'title' => 'Suurlinn'
            ],
            [
                'modifiers' => 'm-green m-active',
                'route' => '#',
                'title' => 'Rannapuhkus'
            ],
            [
                'modifiers' => 'm-green',
                'route' => '#',
                'title' => 'Talvepuhkus'
            ],
            [
                'modifiers' => 'm-green',
                'route' => '#',
                'title' => 'Koolivaheaeg'
            ],
            [
                'modifiers' => 'm-green',
                'route' => '#',
                'title' => 'Eksootiline'
            ],
            [
                'modifiers' => 'm-green',
                'route' => '#',
                'title' => 'Aafrika'
            ],
        ]
    ])
    @include('component.tags', [
        'items' => [
            [
                'modifiers' => 'm-green',
                'route' => '#',
                'title' => 'Veahind'
            ],
            [
                'modifiers' => 'm-green',
                'route' => '#',
                'title' => 'Aasia'
            ],
            [
                'modifiers' => 'm-green',
                'route' => '#',
                'title' => 'Ameerika'
            ],
            [
                'modifiers' => 'm-green m-active',
                'route' => '#',
                'title' => 'Perepuhkus'
            ],
            [
                'modifiers' => 'm-green',
                'route' => '#',
                'title' => 'Šhopping'
            ],
        ]
    ])

@stop

@section('content')

<div class="r-flights">

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
            'image' => \App\Image::getRandom()
        ])
    </div>

    <div class="r-flights__content-wrap">

        <div class="r-flights__content">

            @include('component.row', [
                'modifiers' => 'm-icon m-featured',
                'icon' => 'icon-tickets',
                'title' => 'Riiast Londonisse edasi-tagasi al. 46 €',
                'route' => '',
                'list' => [
                    [
                        'title' => 'Aasia'
                    ],
                    [
                        'title' => '25.10.15'
                    ],
                    [
                        'title' => '250€'
                    ]
                ],
                'badge' => 'Väga hea hind veel ainult täna'
            ])

            @foreach ($contents as $index => $content)

                @include('component.row', [
                    'modifiers' => 'm-icon',
                    'icon' => 'icon-tickets',
                    'title' => $content->title,
                    'route' => route('content.show', [
                        'type' => $content->type,
                        'id' => $content
                    ]),
                    'list' => [
                        [
                            'title' => view('component.date.short', [
                                'date' => $content->end_at
                            ]),
                        ],
                        [
                            'title' => $content->price
                                ? trans("content.flight.index.field.price", [
                                    'price' => $content->price,
                                    'symbol' => config('site.currency.symbol')
                            ]) : null
                        ],
                    ]
                ])

            @endforeach

            @include('component.pagination', [
                'collection' => $contents,
                'text' => [
                    'next' => 'Vanemad pakkumised',
                    'previous' => 'Uuemad pakkumised',
                ]
            ])

            <div class="r-flights__content-block">

                <div class="r-flights__content-block-inner">

                    <div class="r-flights__content-title">

                        @include('component.title', [
                            'title' => 'Otsi lende',
                            'modifiers' => 'm-large m-green'
                        ])
                    </div>

                    <div class="r-flights__content-body">

                        @include('component.text', [
                            'text' => '<p>Kui ei leidnud sobivat pakkumist, siis leia endale meelepärane lend siit.</p>'
                        ])
                    </div>

                    <form action="#">

                        <div class="c-columns m-2-cols m-space m-center">

                            <div class="c-columns__item">

                                <div class="c-form__group">

                                    <input type="text" class="c-form__input" placeholder="Alguspunkt">
                                </div>
                            </div>

                            <div class="c-columns__item">

                                <div class="c-form__group">

                                    <input type="text" class="c-form__input" placeholder="Sihtpunkt">
                                </div>
                            </div>
                        </div>

                        <div class="c-columns m-4-cols m-space m-center">

                            <div class="c-columns__item">

                                <div class="c-form__group">

                                    <div class="c-form__input-wrap">
                                        <span class="c-form__input-icon">

                                            @include('component.svg.sprite', ['name' => 'icon-arrow-right'])

                                        </span>
                                        <input type="date" class="c-form__input m-small m-icon" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="c-columns__item">

                                <div class="c-form__group">

                                    <div class="c-form__input-wrap">
                                        <span class="c-form__input-icon">

                                            @include('component.svg.sprite', ['name' => 'icon-arrow-left'])

                                        </span>
                                        <input type="date" class="c-form__input m-small m-icon" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="c-columns__item">

                                <div class="c-form__group">

                                    <div class="c-form__input-wrap">

                                        <select name="" id="" class="c-form__input m-small">
                                            <option value="">1 reisija</option>
                                            <option value="">2 reisija</option>
                                            <option value="">3 reisija</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="c-columns__item">

                                <div class="c-form__group">

                                    <input type="submit" class="c-button m-small m-block" value="Otsi">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="r-flights__sidebar">

            <div class="r-flights__sidebar-block">

                <div class="r-flights__sidebar-block-inner">

                    @include('component.about', [
                        'title' => 'Hoiame headel pakkumistel igapäevaselt silma peal ning jagame neid kõigi huvilistega.',
                        'text' => 'Pakkumised võivad aeguda juba paari päevaga. Paremaks orienteerumiseks on vanemad pakkumised eri värvi.',
                        'links' => [
                            [
                                'modifiers' => 'm-icon',
                                'title' => 'Loe lähemalt Trip.ee-st',
                                'route' => '#',
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'modifiers' => 'm-icon',
                                'title' => 'Mis on veahind',
                                'route' => '#',
                                'icon' => 'icon-arrow-right'
                            ]
                        ],
                        'button' => [
                            'modifiers' => 'm-block',
                            'route' => route('content.create', ['type' => $type]),
                            'title' => trans("content.$type.create.title")
                        ]
                    ])

                </div>
            </div>

            <div class="r-flights__sidebar-block">

                <div class="r-flights__sidebar-block-inner">

                    @include('component.filter')
                </div>
            </div>

            <div class="r-flights__sidebar-block">

                @include('component.promo', [
                    'route' => '',
                    'image' => \App\Image::getRandom()
                ])

            </div>

            <div class="r-flights__sidebar-block">

                @include('component.promo', [
                    'route' => '',
                    'image' => \App\Image::getRandom()
                ])

            </div>

            <div class="r-flights__sidebar-block">

                <div class="r-flights__sidebar-block-inner">

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
        </div>

    </div>

    <div class="r-flights__forum">

        <div class="r-flights__forum-wrap">

            <div class="r-flights__forum-title">

                @include('component.title', [
                    'modifiers' => 'm-yellow',
                    'title' => 'Tripikad räägivad'
                ])

            </div>

            <div class="r-flights__forum-column m-first">

                @include('component.content.forum.nav', [
                    'items' => [
                        [
                            'title' => 'Üldfoorum',
                            'route' => '#',
                            'modifiers' => 'm-large m-block'
                        ],
                        [
                            'title' => 'Ost-müük',
                            'route' => '#',
                            'modifiers' => 'm-large m-block'
                        ],
                        [
                            'title' => 'Vaba teema',
                            'route' => '#',
                            'modifiers' => 'm-large m-block'
                        ],
                        [
                            'type' => 'button',
                            'title' => 'Otsi foorumist',
                            'route' => '#',
                            'modifiers' => 'm-secondary m-block'
                        ],
                        [
                            'type' => 'button',
                            'title' => 'Alusta teemat',
                            'route' => '#',
                            'modifiers' => 'm-block'
                        ]
                    ]
                ])

            </div>

            <div class="r-flights__forum-column m-last">

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

    <div class="r-flights__footer-promo">

        <div class="r-flights__footer-promo-wrap">

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
