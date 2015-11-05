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

            {{ $content->title }}

            <div class="c-body">

                @include('component.row', [
                    'profile' => [
                        'modifiers' => '',
                        'image' => $content->user->imagePreset(),
                        'route' => route('user.show', [$content->user])
                    ],
                    'text' => view('component.content.text', ['content' => $content]),
                    'actions' => view('component.actions', ['actions' => $content->getActions()]),
                    'extra' => view('component.flags', ['flags' => $content->getFlags()]),
                    'body' => $content->body_filtered
                ])

            </div>

            @include('component.comment.index', ['comments' => $comments])

            @if (\Auth::check())

                @include('component.comment.create')

            @endif

            <div class="r-flights__content-block">

                <div class="r-flights__content-block-inner">

                    <div class="r-flights__content-title">

                        @include('component.title', [
                            'title' => 'Jaga sõbraga',
                            'modifiers' => 'm-large m-green'
                        ])

                    </div>

                </div>
            </div>

            <div class="r-flights__content-block">

                @include('component.promo', [
                    'route' => '#',
                    'image' => \App\Image::getRandom()
                ])

            </div>

            <div class="r-flights__content-block">

                <div class="r-flights__content-title">

                    @include('component.title', [
                        'modifiers' => 'm-green',
                        'title' => 'Lennupakkumised'
                    ])

                </div>

                @include('component.row', [
                    'icon' => 'icon-offer',
                    'modifiers' => 'm-blue m-icon',
                    'title' => 'easyJeti lennupiletid Tallinnast Milanosse al 65 €',
                    'route' => '#',
                    'text' => 'Itaalia   •   Jaanuar – veebruar 2016   •   Täna 12:32 '
                ])

                @include('component.row', [
                    'icon' => 'icon-offer',
                    'modifiers' => 'm-blue m-icon',
                    'title' => 'easyJeti lennupiletid Tallinnast Milanosse al 65 €',
                    'route' => '#',
                    'text' => 'Itaalia   •   Jaanuar – veebruar 2016   •   Täna 12:32 '
                ])

                @include('component.row', [
                    'icon' => 'icon-offer',
                    'modifiers' => 'm-blue m-icon',
                    'title' => 'easyJeti lennupiletid Tallinnast Milanosse al 65 €',
                    'route' => '#',
                    'text' => 'Itaalia   •   Jaanuar – veebruar 2016   •   Täna 12:32 '
                ])

                @include('component.row', [
                    'icon' => 'icon-offer',
                    'modifiers' => 'm-blue m-icon',
                    'title' => 'easyJeti lennupiletid Tallinnast Milanosse al 65 €',
                    'route' => '#',
                    'text' => 'Itaalia   •   Jaanuar – veebruar 2016   •   Täna 12:32 '
                ])


                @include('component.link', [
                    'title' => 'Vaata kõiki  sooduspakkumisi',
                    'route' => '#'
                ])

            </div>
        </div>

        <div class="r-flights__sidebar">

            <div class="r-flights__sidebar-block">

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

                <div class="r-flights__sidebar-block-inner">

                    <div class="r-flights__sidebar-title">

                        @include('component.title', [
                            'modifiers' => 'm-green',
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
                                    'modifiers' => 'm-inverted m-green',
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
                                    'modifiers' => 'm-inverted m-green',
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
                                    'modifiers' => 'm-inverted m-green',
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
                                    'modifiers' => 'm-green',
                                    'count' => 2
                                ]
                            ]
                        ]
                    ])

                </div>
            </div>

            <div class="r-flights__sidebar-block">

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

            <div class="r-flights__sidebar-block">

                @include('component.promo', [
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

    <div class="r-flights__travel-mates">

        <div class="r-flights__travel-mates-wrap">

            <div class="r-home__travel-mates-title">

                @include('component.title', [
                    'title' => 'Reisikaaslased',
                    'modifiers' => 'm-green'
                ])

            </div>

            <div class="c-columns m-4-cols">

                <div class="c-columns__item">

                    @include('component.profile', [
                        'title' => 'Jaanus Jaaniuss',
                        'age' => '22',
                        'interests' => 'Rooma',
                        'route' => '#',
                        'image' => \App\Image::getRandom()
                    ])

                </div>
                <div class="c-columns__item">

                    @include('component.profile', [
                        'title' => 'Jaanus Jaaniuss',
                        'age' => '22',
                        'interests' => 'Rooma',
                        'route' => '#',
                        'image' => \App\Image::getRandom()
                    ])

                </div>
                <div class="c-columns__item">

                    @include('component.profile', [
                        'title' => 'Jaanus Jaaniuss',
                        'age' => '22',
                        'interests' => 'Rooma',
                        'route' => '#',
                        'image' => \App\Image::getRandom()
                    ])

                </div>
                <div class="c-columns__item">

                    @include('component.profile', [
                        'title' => 'Jaanus Jaaniuss',
                        'age' => '22',
                        'interests' => 'Rooma',
                        'route' => '#',
                        'image' => \App\Image::getRandom()
                    ])

                </div>

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
