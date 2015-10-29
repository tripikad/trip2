@extends('layouts.main')

@section('title')

    {{ trans("content.$type.index.title") }}

@stop

@section('header1.right')

    @include('component.button', [
        'route' => route('content.create', ['type' => $type]),
        'title' => trans("content.$type.create.title")
    ])

@stop

@section('header2.content')

    @include('component.filter')

@stop

@section('content')

<div class="r-flights">

    <div class="r-flights__masthead">

        @include('component.masthead')

    </div>

    <div class="r-flights__content-wrap">

        <div class="r-flights__content">

            @foreach ($contents as $index => $content)

                @include('component.row', [
                    'options' => 'm-icon m-blue',
                    'icon' => 'icon-offer',
                    'heading' => $content->title,
                    'heading_link' => route('content.show', [
                        'type' => $content->type,
                        'id' => $content
                    ]),
                    'description' => view('component.date.short', [
                        'date' => $content->end_at
                    ]),
                    'extra' => $content->price
                        ? trans("content.flight.index.field.price", [
                            'price' => $content->price,
                            'symbol' => config('site.currency.symbol')
                    ]) : null,
                ])

            @endforeach

            {!! $contents->render() !!}

        </div>

        <div class="r-flights__sidebar">

            <div class="r-flights__about">

                @include('component.about', [
                    'title' => 'Hoiame headel pakkumistel igapäevaselt silma peal ning jagame neid kõigi huvilistega.',
                    'text' => 'Pakkumised võivad aeguda juba paari päevaga. Paremaks orienteerumiseks on vanemad pakkumised eri värvi.',
                    'links' => [
                        [
                            'title' => 'Loe lähemalt Trip.ee-st ›',
                            'route' => '#'
                        ],
                        [
                            'title' => 'Mis on veahind ›',
                            'route' => '#',
                        ]
                    ]
                ])

            </div>

            <div class="r-flights__promo">

                @include('component.promo', [
                    'route' => '',
                    'image' => \App\Image::getRandom()
                ])

            </div>

            <div class="r-flights__promo">

                @include('component.promo', [
                    'route' => '',
                    'image' => \App\Image::getRandom()
                ])

            </div>

            <div class="r-flights__about">

                @include('component.about', [
                    'title' => 'Trip.ee on reisihuviliste kogukond, keda ühendab reisipisik ning huvi kaugete maade ja kultuuride vastu.',
                    'links' => [
                        [
                            'title' => 'Loe lähemalt Trip.ee-st ›',
                            'route' => '#'
                        ],
                        [
                            'title' => 'Trip.ee Facebookis ›',
                            'route' => '#',
                        ],
                        [
                            'title' => 'Trip.ee Twitteris ›',
                            'route' => '#',
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

    <div class="r-flights__forum">

        <div class="r-flights__forum-wrap">

            <div class="r-flights__forum-title">

                @include('component.title', [
                    'modifiers' => 'm-yellow',
                    'title' => 'Tripikad räägivad'
                ])

            </div>

            <div class="r-flights__forum-column m-first">

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
