@extends('layouts.main')

@section('title')

    {{ $destination->name }}

@stop

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('masthead.nav')

    @include('component.masthead.nav', [
        'nav_previous_title' => $previous_destination->name,
        'nav_previous_route' => route('destination.show', [$previous_destination]),
        'nav_next_title' => $next_destination->name,
        'nav_next_route' => route('destination.show', [$next_destination]),
        'modifiers' => 'm-yellow'
    ])

@stop

@section('content')

<div class="r-destination">

    <div class="r-destination__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-alternative',
            'subtitle' => (isset($parent_destination) ? $parent_destination->name : null),
            'subtitle_route' => (isset($parent_destination) ? route('destination.show', [$parent_destination]) : null),
            'image' =>
                (isset($features['photos']) && count($features['photos']['contents'])
                    ?
                        $features['photos']['contents']->random(1)->imagePreset()
                    :
                        \App\Image::getRandom()
                )
        ])

    </div>

    <div class="r-destination__about m-yellow">

        <div class="r-destination__about-wrap">

            @if (isset($features['flights']) && count($features['flights']['contents']))

                <div class="r-destination__about-column m-first">

                    <div class="r-destination__title-block m-white m-distribute">

                        @include('component.title', [
                            'modifiers' => 'm-yellow',
                            'title' => trans('destination.show.good.offer')
                        ])

                        @include('component.link', [
                            'modifiers' => 'm-tiny',
                            'title' => trans('destination.show.link.view.all'),
                            'route' => route('content.show', ['flights'])
                        ])

                    </div>

                    @foreach ($features['flights']['contents'] as $flight)

                        @include('component.card', [
                            'modifiers' => 'm-yellow m-small',
                            'route' => route('content.show', [$flight->type, $flight]),
                            'title' => str_limit($flight->title, 50).' '.$flight->price.' '.config('site.currency.symbol'),
                            'image' => $flight->imagePreset(),
                        ])

                    @endforeach

                </div>

            @endif

            <div class="r-destination__about-column
            @if (isset($features['flights']) && count($features['flights']['contents']))
                m-last
            @endif
            ">

                <div class="c-columns m-2-cols m-space">

                    <div class="c-columns__item">

                        @include('component.destination.info',[
                            'modifiers' => 'm-yellow',
                            'definitions' => [
                                [
                                    'term' => trans('destination.show.user.havebeen.title'),
                                    'definition' => $destination->usersHaveBeen()->count()
                                ],
                            ]
                        ])

                    </div>

                    <div class="c-columns__item">

                        @include('component.destination.info',[
                            'modifiers' => 'm-yellow',
                            'definitions' => [
                                [
                                    'term' => trans('destination.show.user.wantstogo.title'),
                                    'definition' => $destination->usersWantsToGo()->count()
                                ],
                            ]
                        ])

                    </div>

                </div>

            </div>

            <div class="r-destination__about-map">

                @include('component.map', [
                    'map_top' => '53%',
                    'map_left' => '50%'
                ])
            </div>

        </div>

    </div>

    <div class="r-destination__content">

        <div class="r-destination__content-wrap">

            <div class="r-destination__content-about">

                <div class="r-destination__content-about-column m-first">

                    @include('component.promo', [
                        'route' => '#',
                        'image' => \App\Image::getRandom()
                    ])

                </div>

                <div class="r-destination__content-about-column m-middle">

                    @if (isset($features['forum_posts']) && count($features['forum_posts']['contents']))

                        <div class="r-destination__content-title">

                            @include('component.title', [
                                'modifiers' => 'm-yellow',
                                'title' => trans('destination.show.forum.title')
                            ])

                        </div>

                        @include('component.content.forum.list', [
                            'modifiers' => 'm-compact',
                            'items' => $features['forum_posts']['contents']->transform(function($forum) {
                                return [
                                    'topic' => $forum->title,
                                    'route' => route('content.show', [$forum->type, $forum]),
                                    'profile' => [
                                        'modifiers' => 'm-mini',
                                        'image' => $forum->user->imagePreset()
                                    ],
                                    'badge' => [
                                        'modifiers' => 'm-inverted',
                                        'count' => $forum->comments->count()
                                    ]
                                ];
                            })
                        ])
                    @else

                        <p>&nbsp;</p>

                    @endif

                </div>

                <div class="r-destination__content-about-column m-last">

                    <div class="r-destination__content-title">

                        @include('component.title', [
                            'modifiers' => 'm-yellow',
                            'title' => trans('destination.show.popular.title')
                        ])

                    </div>

                    @include('component.list', [
                        'modifiers' => 'm-dot m-yellow',
                        'items' => [
                            [
                                'title' => 'Valletta',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Cottonera',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Hagar Qim and Mnajdra',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Mellieha',
                                'route' => '#'
                            ],
                        ]
                    ])

                </div>

            </div>

            @if (isset($features['photos']) && count($features['photos']['contents']))

                <div class="r-destination__content-gallery">

                    <div class="r-destination__gallery-wrap">

                        @include('component.gallery', [
                            'items' => $features['photos']['contents']->transform(function($photo) {
                                return [
                                    'image' => $photo->imagePreset(),
                                    'route' => route('content.show', [$photo->type, $photo]),
                                    'alt' => $photo->title
                                ];
                            })
                        ])

                    </div>

                </div>

            @endif

            <div class="r-destination__content-news">

                <div class="r-destination__content-news-wrap">

                    <div class="r-destination__content-news-column m-first">

                        @if (isset($features['news']) && count($features['news']['contents']))

                            <div class="r-destination__content-title">

                                @include('component.title', [
                                    'modifiers' => 'm-yellow',
                                    'title' => trans('destination.show.news.title')
                                ])

                            </div>

                            @include('component.list', [
                                'modifiers' => 'm-large',
                                'items' => $features['news']['contents']->transform(function($new) {
                                    return [
                                        'title' => $new->title,
                                        'route' => route('content.show', [$new->type, $new]),
                                        'text' => view('component.date.short', [
                                            'date' => $new->created_at
                                        ])
                                    ];
                                })
                            ])

                        @else

                            <p>&nbsp;</p>

                        @endif

                    </div>

                    <div class="r-destination__content-news-column m-last">

                        @if (isset($features['blog_posts']) && count($features['blog_posts']['contents']))

                            <div class="r-destination__content-title">

                                @include('component.title', [
                                    'modifiers' => 'm-yellow',
                                    'title' => trans('frontpage.index.travelletter.title')
                                ])

                            </div>

                            @foreach($features['blog_posts']['contents'] as $blog)

                                @include('component.blog', [
                                    'title' => $blog->title,
                                    'route' => route('content.show', [$blog->type, $blog]),
                                    'image' => $blog->imagePreset(),
                                    'profile' => [
                                        'route' => route('user.show', [$blog->user]),
                                        'title' => $blog->user->name,
                                        'image' => $blog->user->imagePreset()
                                    ]
                                ])

                            @endforeach

                        @else

                            <p>&nbsp;</p>

                        @endif

                    </div>

                </div>

            </div>

            @if (isset($features['travel_mates']) && count($features['travel_mates']['contents']))

                <div class="r-destination__content-travel-mates">

                    <div class="r-destination__content-travel-mates-wrap">

                        <div class="r-destination__content-title">

                            @include('component.title', [
                                'title' => trans('frontpage.index.travelmate.title'),
                                'modifiers' => 'm-yellow'
                            ])

                        </div>

                        <div class="c-columns m-{{ count($features['travel_mates']['contents']) }}-cols">

                            @foreach($features['travel_mates']['contents'] as $travel_mate)

                                <div class="c-columns__item">

                                    @include('component.profile', [
                                        'title' => $travel_mate->user->name,
                                        'age' => $travel_mate->user->age,
                                        'interests' => $travel_mate->title,
                                        'route' => route('content.show', [$travel_mate->type, $travel_mate]),
                                        'image' => $travel_mate->user->imagePreset()
                                    ])

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            @endif

            @if (isset($features['flights2']) && count($features['flights2']['contents']))

                <div class="r-destination__content-flights">

                    <div class="r-destination__content-flights-wrap">

                        <div class="c-columns m-3-cols">

                            <div class="c-columns__item">

                                @foreach ($features['flights2']['contents'] as $flight)

                                    @include('component.card', [
                                        'route' => route('content.show', [$flight->type, $flight]),
                                        'title' => $flight->title.' '.$flight->price.' '.config('site.currency.symbol'),
                                        'image' => $flight->imagePreset()
                                    ])

                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>

    <div class="r-destination__footer-promo">

        <div class="r-destination__footer-promo-wrap">

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
