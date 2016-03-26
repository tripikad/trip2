@extends('layouts.main')

@section('header')

    @include('component.header', [
        'hide' => ['search'],
    ])

@stop

@section('masthead.search')

    @include('component.search',[
        'modifiers' => 'm-red m-inverted',
        'placeholder' => 'Otsi foorumist...',
    ])

@stop

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('content')
    <div class="r-forum">

        <div class="r-forum__masthead">

            @include('component.masthead', [
                'modifiers' => 'm-search m-logo-title',
                'map' => true,
            ])

        </div>

        <div class="r-forum__wrap">

            <div class="r-forum__content">

                @foreach ($contents as $content)

                    @include('component.row', [
                        'profile' => [
                            'modifiers' => '',
                            'image' => $content->user->imagePreset(),
                            'route' => route('user.show', [$content->user]),
                            'letter' => [
                                'modifiers' => 'm-green m-small',
                                'text' => 'D'
                            ],
                        ],
                        'modifiers' => 'm-image',
                        'title' => $content->title,
                        'route' => route('content.show', [$content->type, $content->id]),
                        'text' => view('component.content.text', ['content' => $content]),
                    ])

                @endforeach

                @include('component.pagination.default', [
                    'collection' => $contents
                ])

            </div>

            <div class="r-forum__sidebar">

                <div class="r-block m-small">
                    @include('component.title', [
                        'modifiers' => 'm-red',
                        'title' => trans('content.'.config('content_'.$type.'.menu').'.sidebar.title')
                    ])
                </div>
                <div class="r-block m-small">
                    @include('component.content.forum.nav', [
                        'items' => config('menu.'.config('content_'.$type.'.menu')),
                    ])
                </div>

                <div class="r-block m-small">

                    <div class="r-block__inner">

                        @include('component.about', [
                            'title' => 'Alusta uut teemat',
                            'text' => 'Soovid midagi küsida? Tripikad vastavad.',
                            'links' => [
                                [
                                    'modifiers' => 'm-icon',
                                    'title' => 'Kasutjaid hetkel 147',
                                    'route' => '',
                                    'icon' => ''
                                ],
                            ],
                            'button' =>
                                \Auth::check() ? [
                                    'modifiers' => 'm-block',
                                    'route' => route('content.create', ['type' => $type]),
                                    'title' => trans("content.$type.create.title")
                                ] : null
                        ])

                    </div>
                </div>

                <div class="r-block m-small">
                    <div class="r-block__inner">
                        @include('component.forum.filter')
                    </div>
                </div>

                <div class="r-block m-small m-mobile-hide">
                    @include('component.promo', [
                        'modifiers' => 'm-sidebar-small',
                        'route' => '',
                        'image' => \App\Image::getRandom()
                    ])
                </div>

                <div class="r-block__inner">
                    <div class="r-block__header">
                        <div class="r-block__header-title m-flex">
                            @include('component.title', [
                                'modifiers' => 'm-blue',
                                'title' => trans('destination.show.forum.title')
                            ])
                        </div>
                    </div>

                    @include('component.content.forum.list', [
                            'modifiers' => 'm-compact',
                            'items' => [
                                [
                                    'topic' => 'Pikaajaliselt paikses LAs',
                                    'route' => '#',
                                    'profile' => [
                                        'modifiers' => 'm-mini',
                                        'image' => \App\Image::getRandom(),
                                        'letter' => [
                                            'modifiers' => 'm-red',
                                            'text' => 'K',
                                        ],
                                    ],
                                    'badge' => [
                                        'modifiers' => 'm-inverted m-blue',
                                        'count' => rand(1, 12),
                                    ]
                                ],
                                [
                                    'topic' => 'Los Angeles, Venice beach',
                                    'route' => '#',
                                    'profile' => [
                                        'modifiers' => 'm-mini',
                                        'image' => \App\Image::getRandom(),
                                        'letter' => [
                                            'modifiers' => 'm-red',
                                            'text' => 'K',
                                        ],
                                    ],
                                    'badge' => [
                                        'modifiers' => 'm-inverted m-blue',
                                        'count' => rand(1, 12),
                                    ]
                                ],
                                [
                                    'topic' => 'Mida teha New Yorgis?',
                                    'route' => '#',
                                    'profile' => [
                                        'modifiers' => 'm-mini',
                                        'image' => \App\Image::getRandom(),
                                        'letter' => [
                                            'modifiers' => 'm-red',
                                            'text' => 'K',
                                        ],
                                    ],
                                    'badge' => [
                                        'modifiers' => 'm-inverted m-blue',
                                        'count' => rand(1, 12),
                                    ]
                                ],
                                [
                                    'topic' => 'Kasulikku infot Washingtoni...',
                                    'route' => '#',
                                    'profile' => [
                                        'modifiers' => 'm-mini',
                                        'image' => \App\Image::getRandom(),
                                        'letter' => [
                                            'modifiers' => 'm-red',
                                            'text' => 'K',
                                        ],
                                    ],
                                    'badge' => [
                                        'modifiers' => 'm-inverted m-blue',
                                        'count' => rand(1, 12),
                                    ]
                                ]
                            ]
                        ])

                </div>

                <div class="r-block m-small m-mobile-hide">

                    @include('component.promo', [
                        'modifiers' => 'm-sidebar-large',
                        'route' => '',
                        'image' => \App\Image::getRandom()
                    ])
                </div>

            </div>

        </div>


        <div class="r-forum__footer-promo">

            <div class="r-forum__footer-promo-wrap">

                @include('component.promo', [
                    'modifiers' => 'm-footer',
                    'route' => '',
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
