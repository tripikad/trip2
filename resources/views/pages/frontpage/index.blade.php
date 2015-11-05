@extends('layouts.main')

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('masthead.search')

    @include('component.search',[
        'modifiers' => 'm-red',
        'placeholder' => 'Where do you want to go today?'
    ])

@stop

@section('content')

    <div class="r-home">

        <div class="r-home__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-search m-alternative',
            'image' => \App\Image::getRandom()
        ])

        </div>

        @if(isset($flights1) && !empty($flights1))

            <div class="r-home__destinations">

                <div class="r-home__destinations-wrap">

                    <div class="c-columns m-3-cols">

                        @foreach($flights1 as $name => $flight1)

                            <div class="c-columns__item">

                                @include('component.destination', [
                                    'modifiers' => $flights1_modifiers[$name],
                                    'title' => 'Aafrika',
                                    'title_route' => '/destination/4',
                                    'subtitle' => 'Itaalia',
                                    'subtitle_route' => '#'
                                ])

                                @include('component.card', [
                                    'modifiers' => $flights1_modifiers[$name],
                                    'route' => route('content.show', [$flight1->type, $flight1]),
                                    'title' => $flight1->title.' '.$flight1->price.' '.config('site.currency.symbol'),
                                    'image' => $flight1->imagePreset(),
                                ])

                            </div>

                        @endforeach

                    </div>
                </div>
            </div>

        @endif

        @if(isset($content) && !empty($content))

            <div class="r-home__about">

                <div class="r-home__about-wrap">

                    @include('component.about', [
                        'modifiers' => 'm-wide',
                        'title' => str_limit($content->body, 300),
                        'links' => [
                            [
                                'title' => trans('frontpage.index.about.title'),
                                'route' => route('content.show', [$content->type, $content]),
                            ]
                        ],
                        'button' => [
                            'title' => trans('frontpage.index.about.register'),
                            'route' => route('register.form'),
                            'modifiers' => 'm-block'
                        ]
                    ])

                </div>
            </div>

        @endif

        <div class="r-home__forum">

            <div class="r-home__forum-wrap">

                <div class="r-home__forum-title">

                    @include('component.title', [
                        'modifiers' => 'm-red',
                        'title' => trans('frontpage.index.forum.title')
                    ])

                </div>

                <div class="r-home__forum-column m-first">

                    @include('component.content.forum.nav', [
                        'items' => [
                            [
                                'title' => 'Üldfoorum',
                                'route' => '#',
                                'modifiers' => 'm-large m-block'
                            ],
                            [
                                'title' => 'Ost-müük',
                                'route' => '#',
                                'modifiers' => 'm-large m-block'
                            ],
                            [
                                'title' => 'Vaba teema',
                                'route' => '#',
                                'modifiers' => 'm-large m-block'
                            ],
                            [
                                'type' => 'button',
                                'title' => 'Otsi foorumist',
                                'route' => '#',
                                'modifiers' => 'm-secondary m-block'
                            ],
                            [
                                'type' => 'button',
                                'title' => 'Alusta teemat',
                                'route' => '#',
                                'modifiers' => 'm-block'
                            ]
                        ]
                    ])

                </div>

                @if(isset($forums) && !empty($forums))

                    <div class="r-home__forum-column m-last">
                        @include('component.content.forum.list', [
                            'items' => $forums->transform(function ($forum) {
                                return [
                                    'topic' => str_limit($forum->title, 50),
                                    'route' => route('content.show', [$forum->type, $forum]),
                                    'profile' => [
                                        'modifiers' => 'm-mini',
                                        'image' => $forum->user->imagePreset()
                                    ],
                                    'badge' => [
                                        'modifiers' => 'm-inverted',
                                        'count' => count($forum->comments)
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
                                ];
                            })
                        ])

                    </div>

                @endif

            </div>
        </div>

        <div class="r-home__news">

            <div class="r-home__news-wrap">

                <div class="r-home__news-column m-first">

                    @include('component.promo', [
                        'route' => '',
                        'image' => \App\Image::getRandom()
                    ])

                </div>

                <div class="r-home__news-column m-last">

                    <div class="r-home__news-title">

                        @include('component.title', [
                            'modifiers' => 'm-red',
                            'title' => trans('frontpage.index.news.title')
                        ])

                    </div>

                    @if(isset($news1) && !empty($news1))

                        <div class="r-home__news-block-wrap">

                            @foreach($news1 as $name => $new)

                                <div class="r-home__news-block @if($name==0) m-first @else m-last @endif">

                                    @include('component.news', [
                                        'title' => $new->title,
                                        'route' => route('content.show', [$new->type, $new]),
                                        'date' => $new->created_at,
                                        'image' => $new->imagePreset(),
                                        'modifiers' => ($name==0?'':'m-small')
                                    ])

                                </div>

                            @endforeach

                        </div>

                    @endif


                    @if(isset($news2) && !empty($news2))

                        @include('component.list', [
                            'items' => $news2->transform(function ($new) {
                                return [
                                    'title' => $new->title,
                                    'route' => route('content.show', [$new->type, $new]),
                                    'text' => view('component.date.short', ['date' => $new->created_at])
                                ];
                            })
                        ])

                    @endif

                    @include('component.link', [
                        'title' => trans('frontpage.index.all.news'),
                        'route' => route('content.show', ['news'])
                    ])

                </div>
            </div>
        </div>

        <div class="r-home__travel">

            <div class="r-home__travel-wrap">

                <div class="r-home__travel-column m-first">

                    <div class="r-home__travel-title">

                        @include('component.title', [
                            'modifiers' => 'm-red',
                            'title' => trans('frontpage.index.flight.title')
                        ])

                    </div>

                    @if(isset($flights2) && !empty($flights2))

                        @foreach($flights2 as $name => $flight2)

                            @include('component.row', [
                                'icon' => 'icon-offer',
                                'modifiers' => $flights2_modifiers[$name].' m-icon',
                                'title' => $flight2->title.' '.$flight2->price.' '.config('site.currency.symbol'),
                                'route' => route('content.show', [$flight2->type, $flight2]),
                                'text' =>
                                    view('component.date.short', ['date' => $flight2->end_at])
                                    .' / '.
                                    view('component.date.relative', ['date' => $flight2->created_at])
                            ])

                        @endforeach

                    @endif

                    @include('component.link', [
                        'title' => trans('frontpage.index.all.offers'),
                        'route' => route('content.show', ['flight'])
                    ])

                </div>

                @if(isset($blogs) && !empty($blogs))

                    <div class="r-home__travel-column m-last">

                        <div class="r-home__travel-title">

                            @include('component.title', [
                                'modifiers' => 'm-red',
                                'title' => trans('frontpage.index.travelletter.title')
                            ])

                        </div>

                        @foreach($blogs as $blog)

                            @include('component.blog', [
                                'title' => $blog->title,
                                'image' => $blog->imagePreset(),
                                'route' => route('content.show', [$blog->type, $blog]),
                                'profile' => [
                                    'route' => route('user.show', [$blog->user]),
                                    'title' => $blog->user->name,
                                    'image' => $blog->user->imagePreset()
                                ]
                            ])

                        @endforeach

                    </div>

                @endif

            </div>
        </div>


        @if(isset($photos) && !empty($photos))

            <div class="r-home__gallery">

                <div class="r-home__gallery-wrap">

                    @include('component.gallery', [
                        'items' => $photos->transform(function ($photo) {
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

        @if(isset($travelmates) && !empty($travelmates))

            <div class="r-home__travel-mates">

                <div class="r-home__travel-mates-wrap">

                    <div class="r-home__travel-mates-title">

                        @include('component.title', [
                            'title' => trans('frontpage.index.travelmate.title'),
                            'modifiers' => 'm-red'
                        ])

                    </div>

                    <div class="c-columns m-4-cols">

                        @foreach($travelmates as $travelmate)

                            <div class="c-columns__item">

                                @include('component.profile', [
                                    'title' => $travelmate->user->name,
                                    'age' => $travelmate->user->age,
                                    'interests' => $travelmate->title,
                                    'route' => route('content.show', [$travelmate->type, $travelmate]),
                                    'image' => $travelmate->user->imagePreset()
                                ])

                            </div>

                        @endforeach

                    </div>
                </div>
            </div>

        @endif


        <div class="r-home__footer-promo">

            <div class="r-home__footer-promo-wrap">

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
