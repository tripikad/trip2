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

            <ul class="c-pager">

                @if ($contents->previousPageUrl())

                <li class="c-pager__item m-first">

                    <a href="{{ $contents->previousPageUrl() }}" class="c-button m-tertiary m-small m-icon-pre">Uuemad pakkumised <span class="c-button__icon">@include('component.icon', ['icon' => 'icon-arrow-left'])</span></a>

                </li>

                @endif

                @if ($contents->nextPageUrl())

                <li class="c-pager__item m-last">

                    <a href="{{ $contents->nextPageUrl() }}" class="c-button m-tertiary m-small m-icon-post">Vanemad pakkumised <span class="c-button__icon">@include('component.icon', ['icon' => 'icon-arrow-right'])</span></a>

                </li>

                @endif

            </ul>


            <div class="r-flights__search">

                <div class="r-flights__search-title">

                    @include('component.title', [
                        'title' => 'Otsi lende',
                        'modifiers' => 'm-large m-green'
                    ])

                </div>

                <div class="r-flights__search-body">

                    <p>Kui ei leidnud sobivat pakkumist, siis leia endale meelepärane lend siit.</p>

                </div>

                <form action="#" class="r-flights__search-form">

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
                                    <span class="c-form__input-icon">@include('component.icon', ['icon' => 'icon-arrow-right'])</span>
                                    <input type="date" class="c-form__input m-small m-icon" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="c-columns__item">

                            <div class="c-form__group">

                                <div class="c-form__input-wrap">
                                    <span class="c-form__input-icon">@include('component.icon', ['icon' => 'icon-arrow-left'])</span>
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
