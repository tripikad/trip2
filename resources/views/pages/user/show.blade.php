@extends('layouts.main')

@section('title')

    {{ $user->name }}

@stop

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('content')

<div class="r-user m-green">

    <div class="r-user__header">

        <div class="r-user__masthead">

            @include('component.masthead', [
                'modifiers' => 'm-alternative m-profile',
                'image' => \App\Image::getRandom()
            ])

        </div>

        <div class="r-user__info">

            <div class="r-user__map">

                @include('component.map')

            </div>

            <div class="r-user__info-extra">

            </div>

            <div class="r-user__info-wrap">

                <div class="r-user__info-image">

                    @include('component.profile', [
                        'image' => $user->imagePreset('small_square'),
                        'modifiers' => 'm-full',
                    ])

                    <div class="r-user__info-travel-mate">

                        @include('component.tooltip', [
                            'modifiers' => 'm-green m-bottom',
                            'text' => 'Otsin reisikaaslast',
                            'link' => view('component.link', ['title' => 'Loe lähemalt', 'route' => '#', 'modifiers' => 'm-small'])
                         ])
                    </div>
                </div>

                <div class="r-user__info-actions">

                    @if (\Auth::check() && \Auth::user()->id !== $user->id)

                        @include('component.button', [
                            'modifiers' => 'm-secondary',
                            'route' => route('message.index.with', [
                                \Auth::user(),
                                $user,
                                '#message'
                            ]),
                            'title' => trans('user.show.message.create')
                        ])

                    @endif

                    @include('component.button.group',[
                        'items' => [
                            [
                                'button' => view('component.button',[
                                    'modifiers' => 'm-secondary m-small',
                                    'title' => 'Saada sõnum',
                                    'route' => ''
                                ])
                            ],
                            [
                                'button' => view('component.button',[
                                    'modifiers' => 'm-border m-small',
                                    'title' => 'Jälgi',
                                    'route' => ''
                                ]),
                            ],
                            [
                                'button' => view('component.button',[
                                    'modifiers' => 'm-icon m-small m-round',
                                    'icon' => view('component.icon',['icon' => 'icon-facebook']),
                                    'route' => '#'
                                ]),
                            ],
                            [
                                'button' => view('component.button',[
                                    'modifiers' => 'm-icon m-small m-round',
                                    'icon' => view('component.icon',['icon' => 'icon-twitter']),
                                    'route' => '#'
                                ]),
                            ]
                        ]
                    ])

                    @include('component.user.contact')
                </div>

                <div class="r-user__info-title">

                    @include ('component.title', [
                        'modifiers' => 'm-huge m-white',
                        'title' => $user->name
                    ])
                </div>

                <div class="r-user__info-description">

                    @include('component.user.description',[
                        'text' => 'Kuigi viikingite laevad jõudsid Põhja-Ameerikasse ligi 500 aastat enne Kolumbuse retke, tekkis Euroopal püsiv kontakt tolle Uue Maailmaga alles tänu Kolumbuse avastusele.'
                    ])

                    <p>
                     {{ trans('user.show.joined', [
                         'created_at' => view('component.date.relative', ['date' => $user->created_at])
                     ]) }}
                     </p>
                </div>

                @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('admin', $user->id) || \Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))

                    <div class="r-user__info-admin">

                        @include('component.button.group',[
                            'items' => [
                                [
                                    'button' => view('component.button',[
                                        'modifiers' => 'm-small',
                                        'title' => trans('user.edit.title'),
                                        'route' => route('user.edit', [$user]),
                                    ])
                                ],
                                [
                                    'button' => view('component.button',[
                                        'modifiers' => 'm-secondary m-small',
                                        'title' => 'Activity',
                                        'route' => route('user.show', [$user])
                                    ])
                                ],
                                [
                                    'button' => view('component.button',[
                                        'modifiers' => 'm-secondary m-small',
                                        'title' => 'Messages',
                                        'route' => route('message.index', [$user])
                                    ]),
                                ],
                                [
                                    'button' => view('component.button',[
                                        'modifiers' => 'm-secondary m-small',
                                        'title' => 'Follows',
                                        'route' => route('follow.index', [$user])
                                    ]),
                                ]
                            ]
                        ])

                     </div>

                @endif

             </div>

        </div>

    </div>

    <div class="r-user__gallery">

        <div class="r-user__gallery-wrap">

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
                ],
                'more_count' => '119',
                'more_route' => '#'
            ])

        </div>

    </div>

    <div class="r-user__additional">

        <div class="r-user__additional-wrap">

            <div class="r-user__additional-content">

                <div class="r-user__additional-header">

                    <div class="r-user__additional-title">

                        @include('component.title', [
                            'modifiers' => 'm-green',
                            'title' => 'Viimased postitused'
                        ])

                    </div>

                    <div class="r-user__additional-action">

                        @include('component.link', [
                            'modifiers' => 'm-small',
                            'title' => 'Trip.ee foorum',
                            'route' => '#'
                        ])

                    </div>
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
                            ],
                            'children' => [
                                [
                                    'profile' => [
                                        'modifiers' => 'm-mini',
                                        'image' => \App\Image::getRandom(),
                                        'title' => 'Charles Darwin',
                                        'route' => ''
                                    ],
                                    'date' => '12. jaanuar, 12:31',
                                    'text' => 'Mina puurisin nüüd juba mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid.',

                                ]
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
                            ],
                            'children' => [
                                [
                                    'profile' => [
                                        'modifiers' => 'm-mini',
                                        'image' => \App\Image::getRandom(),
                                        'title' => 'Charles Darwin',
                                        'route' => ''
                                    ],
                                    'date' => '12. jaanuar, 12:31',
                                    'text' => 'Mina puurisin nüüd juba mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne.',

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
                                'modifiers' => 'm-inverted m-green',
                                'count' => 2
                            ],
                            'children' => [
                                [
                                    'profile' => [
                                        'modifiers' => 'm-mini',
                                        'image' => \App\Image::getRandom(),
                                        'title' => 'Charles Darwin',
                                        'route' => ''
                                    ],
                                    'date' => '12. jaanuar, 12:31',
                                    'text' => 'Mina puurisin nüüd juba mitu-mitu aastat tagasi.',

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
                                'modifiers' => 'm-green',
                                'count' => 2
                            ],
                            'children' => [
                                [
                                    'profile' => [
                                        'modifiers' => 'm-mini',
                                        'image' => \App\Image::getRandom(),
                                        'title' => 'Charles Darwin',
                                        'route' => ''
                                    ],
                                    'date' => '12. jaanuar, 12:31',
                                    'text' => 'Mina puurisin nüüd juba kui välja arvata mõned nüansid mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid.',

                                ]
                            ]
                        ]
                    ]
                ])


                <div style="display: none;">

                    @include('component.user.count', [
                        'content_count' => $content_count,
                        'comment_count' => $comment_count
                    ])

                    @if (count($user->destinationHaveBeen()) > 0 || count($user->destinationWantsToGo()) > 0)

                        <div class="utils-border-bottom">

                                @if (count($user->destinationHaveBeen()) > 0)

                                    <h3>{{ trans('user.show.havebeen.title') }}</h3>

                                    @include('component.user.destination', [
                                        'destinations' => $user->destinationHaveBeen()
                                    ])

                                @endif

                        </div>

                        <div class="utils-border-bottom">

                                @if (count($user->destinationWantsToGo()) > 0)

                                    <h3>{{ trans('user.show.wantstogo.title') }}</h3>

                                    @include('component.user.destination', [
                                        'destinations' => $user->destinationWantsToGo()
                                    ])

                                @endif

                        </div>

                    @endif


                    @include('component.user.activity', [
                        'items' => $items
                    ])
                </div>

            </div>

            <div class="r-user__additional-sidebar">

                <div class="r-user__additional-block">

                    <div class="r-user__additional-header">

                        <div class="r-user__additional-title">

                            @include('component.title', [
                                'modifiers' => 'm-green',
                                'title' => 'Reisikirjad'
                            ])

                        </div>

                        <div class="r-user__additional-action">

                            @include('component.link', [
                                'modifiers' => 'm-small',
                                'title' => 'Veel',
                                'route' => '#'
                            ])

                        </div>
                    </div>

                    @include('component.blog', [
                        'title' => 'Minu Malta  – jutustusi kuuajaselt ringreisilt',
                        'route' => '#',
                        'image' => \App\Image::getRandom(),
                    ])

                </div>

                <div class="r-user__additional-block">

                    @include('component.promo', [
                        'route' => '#',
                        'image' => \App\Image::getRandom()
                    ])

                </div>

                <div class="r-user__additional-block">

                    @include('component.promo', [
                        'route' => '#',
                        'image' => \App\Image::getRandom()
                    ])

                </div>

            </div>

        </div>

    </div>

    <div class="r-user__offers">

        <div class="r-user__offers-wrap">

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


    <div class="r-user__footer-promo">

        <div class="r-user__footer-promo-wrap">

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
