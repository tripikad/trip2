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

@if (\Auth::check() && \Auth::user()->hasRoleOrOwner('admin', $user->id) || \Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))

<div class="r-user m-green m-logged-in">

@else

<div class="r-user m-green">

@endif

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

            <div class="r-user__info-wrap">

                <div class="r-user__info-image">

                    @include('component.profile', [
                        'image' => $user->imagePreset('small_square'),
                        'modifiers' => 'm-full m-green',
                    ])

                    <div class="r-user__info-travel-mate">

                        @include('component.tooltip', [
                            'modifiers' => 'm-green m-bottom m-one-line',
                            'text' => 'Otsin reisikaaslast',
                            'link' => view('component.link', [
                                'title' => 'Loe lähemalt',
                                'route' => '#',
                                'modifiers' => 'm-small'
                            ])
                         ])

                    </div>

                </div>

                <div class="r-user__info-actions">

                    <ul class="c-button-group">

                        <li class="c-button-group__item">

                            @if (\Auth::user())

                                @if(\Auth::user()->id !== $user->id)

                                    @include('component.button',[
                                        'modifiers' => 'm-secondary m-small',
                                        'title' => trans('user.show.message.create'),
                                        'route' => route('message.index.with', [
                                            \Auth::user(),
                                            $user,
                                            '#message'
                                        ])
                                    ])

                                @else

                                    @include('component.button',[
                                        'modifiers' => 'm-secondary m-small',
                                        'title' => trans('menu.user.message'),
                                        'route' => route('message.index', [$user])
                                    ])

                                @endif

                            @else

                                @include('component.button',[
                                    'modifiers' => 'm-secondary m-small m-disabled',
                                    'title' => trans('user.show.message.create')
                                ])

                            @endif

                        </li>

                        @if (\Auth::user() && \Auth::user()->id == $user->id)

                            <li class="c-button-group__item">

                                @include('component.button',[
                                    'modifiers' => 'm-border m-small',
                                    'title' => trans('menu.user.follow'),
                                    'route' => route('follow.index', [$user])
                                ])

                            </li>

                        @endif


                        @if (isset($user->contact_facebook) && $user->contact_facebook != '')

                            <li class="c-button-group__item">

                                @include('component.button',[
                                    'modifiers' => (
                                        \Auth::check() ? 'm-icon m-small m-round' : 'm-icon m-small m-round m-disabled'
                                    ),
                                    'icon' => view('component.icon',['icon' => 'icon-facebook']),
                                    'route' => (\Auth::check()
                                        ?
                                            $user->contact_facebook
                                        :
                                            false
                                    ),
                                    'target' => '_blank'
                                ])

                            </li>

                        @endif

                        @if (isset($user->contact_twitter) && $user->contact_twitter != '')

                            <li class="c-button-group__item">

                                @include('component.button',[
                                    'modifiers' => (
                                        \Auth::check() ? 'm-icon m-small m-round' : 'm-icon m-small m-round m-disabled'
                                    ),
                                    'icon' => view('component.icon',['icon' => 'icon-twitter']),
                                    'route' => (\Auth::check()
                                        ?
                                            $user->contact_twitter
                                        :
                                            false
                                    ),
                                    'target' => '_blank'
                                ])

                            </li>

                        @endif

                        @if (isset($user->contact_instagram) && $user->contact_instagram != '')

                            <li class="c-button-group__item">

                                @include('component.button',[
                                    'modifiers' => (
                                        \Auth::check() ? 'm-icon m-small m-round' : 'm-icon m-small m-round m-disabled'
                                    ),
                                    'icon' => view('component.icon',['icon' => 'icon-instagram']),
                                    'route' => (\Auth::check()
                                        ?
                                            $user->contact_instagram
                                        :
                                            false
                                    ),
                                    'target' => '_blank'
                                ])

                            </li>

                        @endif

                        @if (isset($user->contact_homepage) && $user->contact_homepage != '')

                            <li class="c-button-group__item">

                                @include('component.button',[
                                    'modifiers' => (
                                        \Auth::check() ? 'm-icon m-small m-round' : 'm-icon m-small m-round m-disabled'
                                    ),
                                    'icon' => view('component.icon',['icon' => 'icon-homepage']),
                                    'route' => (\Auth::check()
                                        ?
                                            $user->contact_homepage
                                        :
                                            false
                                    ),
                                    'target' => '_blank'
                                ])

                            </li>

                        @endif

                    </ul>

                </div>

                <div class="r-user__info-heading">

                    <div class="r-user__info-title">

                        @include ('component.title', [
                            'modifiers' => 'm-huge m-white',
                            'title' => $user->name
                        ])

                    </div>

                    <div class="r-user__info-status">

                        <div class="r-user__info-status-icon">

                            @include ('component.icon', [
                                'icon' => 'icon-umbrella'
                            ])

                        </div>

                        <div class="r-user__info-status-text">

                            @include ('component.badge', [
                                'modifiers' => 'm-green m-dark m-inverted',
                                'title' => 'Amateur'
                            ])

                        </div>

                    </div>

                </div>

                <div class="r-user__info-description">

                    @include('component.user.description',[
                        'text' => 'Kuigi viikingite laevad jõudsid Põhja-Ameerikasse ligi 500 aastat enne Kolumbuse retke, tekkis Euroopal püsiv kontakt tolle Uue Maailmaga alles tänu Kolumbuse avastusele.'
                    ])

                </div>

                @if (\Auth::check() && (\Auth::user()->hasRoleOrOwner('admin', $user->id) || \Auth::user()->hasRoleOrOwner('superuser', $user->id)))

                    <div class="r-user__info-admin">

                        @include('component.button.group',[
                            'items' => [
                                [
                                    'modifiers' => '',
                                    'button' => view('component.button',[
                                        'modifiers' => 'm-secondary m-small',
                                        'title' => trans('menu.user.edit.profile'),
                                        'route' => route('user.edit', [$user]),
                                    ])
                                ],
                                [
                                    'modifiers' => '',
                                    'button' => view('component.button',[
                                        'modifiers' => 'm-small m-border',
                                        'title' => trans('menu.user.travelmate'),
                                        'route' => route('content.create', ['type' => 'travelmate']),
                                    ])
                                ],
                                [
                                    'modifiers' => 'm-hide',
                                    'button' => view('component.button',[
                                        'modifiers' => 'm-secondary m-small',
                                        'title' => trans('menu.user.activity'),
                                        'route' => route('user.show', [$user])
                                    ])
                                ],
                                [
                                    'modifiers' => 'm-right',
                                    'button' => view('component.button',[
                                        'modifiers' => 'm-secondary m-small',
                                        'title' => trans('menu.user.add.places'),
                                        'route' => '#'
                                    ]),
                                ]
                            ]
                        ])

                     </div>

                @endif

                <div class="r-user__info-extra">

                    @include('component.user.extra', [
                        'items' => [
                            [
                                'icon' => 'icon-comment',
                                'title' =>
                                    (isset($content_count) ? intval($content_count) : 0)
                                    .' / '.
                                    (isset($comment_count) ? intval($comment_count) : 0),
                                'text' =>
                                    trans('user.show.count.content.title')
                                    .' / '.
                                    trans('user.show.count.comment.title'),
                                'route' => ''
                            ],
                            [
                                'icon' => 'icon-pin',
                                'title' => '31 (19%)',
                                'text' => 'Külastatud sihtkohti',
                                'route' => ''
                            ],
                        ]
                    ])

                </div>

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
                                        'image' => \App\Image::getRandom(),
                                        'title' => 'Charles Darwin',
                                        'route' => ''
                                    ],
                                    'date' => '12. jaanuar, 12:31',
                                    'text' => '<p>Mina puurisin nüüd juba mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi.</p><p>Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid.</p>',
                                    'more' =>[
                                        'title' => 'Vaata kogu teemat',
                                        'route' => ''
                                    ]
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
                                        'image' => \App\Image::getRandom(),
                                        'title' => 'Charles Darwin',
                                        'route' => ''
                                    ],
                                    'date' => '12. jaanuar, 12:31',
                                    'text' => '<p>Mina puurisin nüüd juba mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne.</p>',
                                    'more' =>[
                                        'title' => 'Vaata kogu teemat',
                                        'route' => ''
                                    ]
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
                                        'image' => \App\Image::getRandom(),
                                        'title' => 'Charles Darwin',
                                        'route' => ''
                                    ],
                                    'date' => '12. jaanuar, 12:31',
                                    'text' => '<p>Mina puurisin nüüd juba mitu-mitu aastat tagasi.</p>',
                                    'more' =>[
                                        'title' => 'Vaata kogu teemat',
                                        'route' => ''
                                    ]
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
                                        'image' => \App\Image::getRandom(),
                                        'title' => 'Charles Darwin',
                                        'route' => ''
                                    ],
                                    'date' => '12. jaanuar, 12:31',
                                    'text' => '<p>Mina puurisin nüüd juba kui välja arvata mõned nüansid mitu-mitu aastat tagasi oma Kagu-Aasia reiside eel samuti mitme (Eesti) kindlustusfirma tingimusi. Muidu olid välistused jne suhteliselt ühtsed, kui välja arvata mõned nüansid.</p>',
                                    'more' =>[
                                        'title' => 'Vaata kogu teemat',
                                        'route' => ''
                                    ]
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
