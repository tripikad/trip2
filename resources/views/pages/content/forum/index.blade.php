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
        'types' => ['forum'],
    ])
@stop

@section('head_description', trans("site.description.$type"))

@section('title', trans("content.$type.index.title"))

@section('content')
    <div class="r-forum">
        <div class="r-forum__masthead">
            @include('component.masthead', [
                'modifiers' => 'm-search m-logo-title',
                'map' => true,
            ])
        </div>
        <div class="r-forum__wrap m-large-offset-bottom">
            @if (isset($contents) && count($contents))
                <div class="r-forum__content">
                    @include('region.content.forum.list', [
                        'items' => $contents,
                        'tags' => [
                            'take' => 2,
                        ],
                    ])

                    @include('component.pagination.default', [
                        'collection' => $contents
                    ])
                </div>
            @endif

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
                    @include('component.promo', ['promo' => 'sidebar_small'])
                </div>

                <?php /* To-do V2
                <div class="r-block__inner">
                    <div class="r-block__header">
                        <div class="r-block__header-title m-flex">
                            #include('component.title', [
                                'modifiers' => 'm-blue',
                                'title' => trans('content.forum.popular.title')
                            ])
                        </div>
                    </div>

                    #include('component.content.forum.list', [
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
                */
                ?>

                <div class="r-block m-small m-mobile-hide">

                    @include('component.promo', ['promo' => 'sidebar_large'])

                </div>

            </div>

        </div>

        @if (isset($flights) && count($flights))

            <div class="r-forum__offers m-large-offset-bottom">
                <div class="r-forum__offers-wrap">
                    <div class="c-columns m-{{ count($flights) }}-cols">

                        @foreach($flights as $flight)

                            <div class="c-columns__item">

                                @include('component.card', [
                                    'modifiers' => 'm-blue',
                                    'route' => route($flight->type.'.show', [$flight->slug]),
                                    'title' => $flight->title.' '.$flight->price.config('site.currency.symbol'),
                                    'image' => $flight->imagePreset()
                                ])

                            </div>

                        @endforeach

                    </div>
                </div>
            </div>

        @endif


        <div class="r-forum__footer-promo">
            <div class="r-forum__footer-promo-wrap">
                @include('component.promo', ['promo' => 'footer'])
            </div>
        </div>
    </div>

@stop

@section('footer')

    @include('component.footer', [
        'modifiers' => 'm-alternative',
        'image' => \App\Image::getFooter()
    ])

@stop
