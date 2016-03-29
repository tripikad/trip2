@extends('layouts.main')

@section('title')

    {{ trans("content.$type.index.title") }}

@stop

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

{{-- To-do V2
@if (isset($uniqueTopics) && count($uniqueTopics))
    @section('masthead.bottom')
        @include('component.tags', [
            'items' => $uniqueTopics->transform(function ($uniqueTopic) {
                return [
                    'modifiers' => 'm-green' .
                        (Input::get('topic_id')==$uniqueTopic['id']?' m-active' : ''),
                    'route' => '?topic_id='.$uniqueTopic['id'],
                    'title' => $uniqueTopic['name'],
                ];
            })
        ])
    @stop
@endif
--}}

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

        {{-- To-do V2
        <div class="r-flights__content-filter">
            @include('component.range_filter')
        </div>
        --}}

        <div class="r-flights__content">

            {{-- List option for flight offers

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

            --}}

            @include('component.content.flight.block', [
                'items' => [
                    [
                        'image' => \App\Image::getRandom(),
                        'route' => '/content/flight/93904',
                        'title' => 'Edasi-tagasi lennupiletid Tallinnast Bangkokki',
                        'price' => 'al 472 €',
                        'meta' => view('component.inline_list', [
                            'modifiers' => 'm-light m-small',
                            'items' => [
                                [
                                    'title' => 'Aasia',
                                ],
                                [
                                    'title' => 'Täna 12.31',
                                ],
                            ]
                        ])
                    ],
                    [
                        'image' => \App\Image::getRandom(),
                        'route' => '/content/flight/93904',
                        'title' => 'AirAsia kampaania SALE lennupiletid',
                        'price' => 'al 6 €',
                        'meta' => view('component.inline_list', [
                            'modifiers' => 'm-light m-small',
                            'items' => [
                                [
                                    'title' => 'Aasia',
                                ],
                                [
                                    'title' => 'Täna 12.31',
                                ],
                            ]
                        ])
                    ],
                    [
                        'image' => \App\Image::getRandom(),
                        'route' => '#',
                        'title' => 'Helsinkist Aasiasse puhkama',
                        'price' => 'al 472 €',
                        'meta' => view('component.inline_list', [
                            'modifiers' => 'm-light m-small',
                            'items' => [
                                [
                                    'title' => 'Aasia',
                                ],
                                [
                                    'title' => 'Täna 12.31',
                                ],
                            ]
                        ])
                    ],
                    [
                        'image' => \App\Image::getRandom(),
                        'route' => '#',
                        'title' => 'AirAsia kampaania SALE lennupiletid',
                        'price' => 'al 6 €',
                        'meta' => view('component.inline_list', [
                            'modifiers' => 'm-light m-small',
                            'items' => [
                                [
                                    'title' => 'Aasia',
                                ],
                                [
                                    'title' => 'Täna 12.31',
                                ],
                            ]
                        ])
                    ],
                ]
            ])

            <div class="r-block m-mobile-hide">

                @include('component.promo', [
                    'modifiers' => 'm-body',
                    'route' => '',
                    'image' => \App\Image::getRandom()
                ])
            </div>

            @include('component.content.flight.block', [
                'items' => [
                    [
                        'image' => \App\Image::getRandom(),
                        'route' => '#',
                        'title' => 'Edasi-tagasi lennupiletid Tallinnast Bangkokki',
                        'price' => 'al 472 €',
                        'meta' => view('component.inline_list', [
                            'modifiers' => 'm-light m-small',
                            'items' => [
                                [
                                    'title' => 'Aasia',
                                ],
                                [
                                    'title' => 'Täna 12.31',
                                ],
                            ]
                        ])
                    ],
                    [
                        'image' => \App\Image::getRandom(),
                        'route' => '#',
                        'title' => 'AirAsia kampaania SALE lennupiletid',
                        'price' => 'al 6 €',
                        'meta' => view('component.inline_list', [
                            'modifiers' => 'm-light m-small',
                            'items' => [
                                [
                                    'title' => 'Aasia',
                                ],
                                [
                                    'title' => 'Täna 12.31',
                                ],
                            ]
                        ])
                    ],
                    [
                        'image' => \App\Image::getRandom(),
                        'route' => '#',
                        'title' => 'Edasi-tagasi lennupiletid Tallinnast Bangkokki',
                        'price' => 'al 472 €',
                        'meta' => view('component.inline_list', [
                            'modifiers' => 'm-light m-small',
                            'items' => [
                                [
                                    'title' => 'Aasia',
                                ],
                                [
                                    'title' => 'Täna 12.31',
                                ],
                            ]
                        ])
                    ],
                    [
                        'image' => \App\Image::getRandom(),
                        'route' => '#',
                        'title' => 'AirAsia kampaania SALE lennupiletid',
                        'price' => 'al 6 €',
                        'meta' => view('component.inline_list', [
                            'modifiers' => 'm-light m-small',
                            'items' => [
                                [
                                    'title' => 'Aasia',
                                ],
                                [
                                    'title' => 'Täna 12.31',
                                ],
                            ]
                        ])
                    ],
                ]
            ])

            @include('component.pagination.default', [
                'collection' => $contents,
                'text' => [
                    'next' => 'Vanemad pakkumised',
                    'previous' => 'Uuemad pakkumised',
                ]
            ])

            <!-- <div class="r-block">

                <div class="r-block__inner">

                    <div class="r-block__header">

                        <div class="r-block__header-title">

                            @include('component.title', [
                                'title' => 'Otsi lende',
                                'modifiers' => 'm-large m-green'
                            ])
                        </div>
                    </div>

                    <div class="r-block__body">

                        <div class="c-body">
                            <p>Kui ei leidnud sobivat pakkumist, siis leia endale meelepärane lend siit.</p>
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
                                            <div class="c-form__group-select">
                                                <select name="" id="" class="c-form__select m-small">
                                                    <option value="">1 reisija</option>
                                                    <option value="">2 reisija</option>
                                                    <option value="">3 reisija</option>
                                                </select>
                                            </div>
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
            </div> -->

            {{-- To-do V2
            <div class="r-flights__search">
                <div class="c-flight-search">
                    <div class="c-flight-search__header">
                        <div class="c-flight-search__header-title">
                            @include('component.title', [
                                'title' => 'Otsi lende',
                                'modifiers' => 'm-large m-green'
                            ])
                        </div>
                        <p class="c-flight-search__header-text">Kui ei leidnud sobivat pakkumist, siis leia endale meelepärane lend siit.</p>
                    </div>
                    <div class="c-flight-search__row m-first">
                        <div class="c-flight-search__row-column">
                            <div class="c-form__group">
                                <input type="text" class="c-form__input" value="Tallinn">
                            </div>
                        </div>
                        <div class="c-flight-search__row-column">
                            <div class="c-form__group">
                                <input type="text" class="c-form__input" placeholder="Sihtpunkt">
                            </div>
                        </div>
                    </div>

                    <div class="c-flight-search__row m-last">
                        <div class="c-flight-search__row-column">
                            <div class="c-form__group">
                                <div class="c-form__input-wrap">
                                    <span class="c-form__input-icon">
                                        @include('component.svg.sprite', ['name' => 'icon-arrow-right'])
                                    </span>
                                    <input type="text" class="c-form__input m-medium m-icon" value="25.02.2016">
                                </div>
                            </div>
                        </div>
                        <div class="c-flight-search__row-column">
                            <div class="c-form__group m-error">
                                <div class="c-form__input-wrap">
                                    <span class="c-form__input-icon">
                                        @include('component.svg.sprite', ['name' => 'icon-arrow-left'])
                                    </span>
                                    <input type="text" class="c-form__input m-medium m-icon" value="30.02.2016">
                                </div>
                            </div>
                        </div>
                        <div class="c-flight-search__row-column">
                            <div class="c-form__group">
                                <div class="c-form__group-select">
                                    <select name="" id="" class="c-form__select m-medium">
                                        <option value="">1 reisija</option>
                                        <option value="">2 reisija</option>
                                        <option value="">3 reisija</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="c-flight-search__row-column">
                            <input type="submit" class="c-button m-medium m-block" value="Otsi">
                        </div>
                    </div>
                </div>
            </div>
            --}}
        </div>

        <div class="r-flights__sidebar">
            <div class="r-block m-small">
                <div class="r-block__inner">
                    @include('component.filter')
                </div>
            </div>

            <div class="r-block m-small">
                <div class="r-block__inner">

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

            <div class="r-block m-small m-mobile-hide">

                @include('component.promo', [
                    'modifiers' => 'm-sidebar-large',
                    'route' => '',
                    'image' => \App\Image::getRandom()
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
                    'modifiers' => 'm-red',
                    'title' => 'Tripikad räägivad'
                ])

            </div>

            <div class="r-flights__forum-column m-first">

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

            <div class="r-flights__forum-column m-last">

                @include('component.content.forum.list', [
                    'items' => [
                        [
                            'topic' => 'Samui hotellid?',
                            'route' => '#',
                            'date' => 'Täna, 15:12',
                            'profile' => [
                                'modifiers' => 'm-mini',
                                'image' => \App\Image::getRandom(),
                                'letter' => [
                                    'modifiers' => 'm-green m-small',
                                    'text' => 'D'
                                ],
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
                                'image' => \App\Image::getRandom(),
                                'letter' => [
                                    'modifiers' => 'm-green m-small',
                                    'text' => 'D'
                                ],
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
                                'image' => \App\Image::getRandom(),
                                'letter' => [
                                    'modifiers' => 'm-green m-small',
                                    'text' => 'D'
                                ],
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
                                'image' => \App\Image::getRandom(),
                                'letter' => [
                                    'modifiers' => 'm-green m-small',
                                    'text' => 'D'
                                ],
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
                        ],
                        [
                            'topic' => 'Samui hotellid?',
                            'route' => '#',
                            'date' => 'Täna, 15:12',
                            'profile' => [
                                'modifiers' => 'm-mini',
                                'image' => \App\Image::getRandom(),
                                'letter' => [
                                    'modifiers' => 'm-green m-small',
                                    'text' => 'D'
                                ],
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
                                'image' => \App\Image::getRandom(),
                                'letter' => [
                                    'modifiers' => 'm-green m-small',
                                    'text' => 'D'
                                ],
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
                                'image' => \App\Image::getRandom(),
                                'letter' => [
                                    'modifiers' => 'm-green m-small',
                                    'text' => 'D'
                                ],
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
                    ]
                ])
            </div>
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
