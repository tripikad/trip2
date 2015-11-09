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

    <div class="r-user__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-alternative m-profile',
            'image' => \App\Image::getRandom()
        ])

    </div>

    <div class="r-user__info">

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
                        'text' => 'Otsin reisikaaslast'
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

                @include('component.button',[
                    'modifiers' => 'm-secondary m-small',
                    'title' => 'Saada sõnum',
                    'route' => ''
                ])

                @include('component.button',[
                    'modifiers' => 'm-border m-small',
                    'title' => 'Jälgi',
                    'route' => ''
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

                <p>
                 {{ trans('user.show.joined', [
                     'created_at' => view('component.date.relative', ['date' => $user->created_at])
                 ]) }}
                 </p>
            </div>

             @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('admin', $user->id))

                <div class="r-user__info-admin">

                 @include('component.button', [
                     'route' => route('user.edit', [$user]),
                     'title' => trans('user.edit.title')
                 ])

                 </div>

             @endif

             @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))

                 <div class="r-user__info-admin">

                     @include('component.nav', [
                         'menu' => 'user',
                         'items' => [
                             'activity' => ['route' => route('user.show', [$user])],
                             'message' => ['route' => route('message.index', [$user])],
                             'follow' => ['route' => route('follow.index', [$user])]
                         ],
                         'options' => 'text-center'
                     ])

                 </div>

             @endif

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
                                'modifiers' => 'm-inverted',
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
                                'modifiers' => 'm-inverted',
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
                                'modifiers' => 'm-inverted',
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
                                'modifiers' => '',
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
