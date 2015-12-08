@extends('layouts.main')

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('masthead.search')

    @include('component.search',[
        'modifiers' => 'm-red',
        'placeholder' => trans('frontpage.index.search.title')
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

        @if (isset($flights1) && ! empty($flights1))

            <div class="r-home__destinations">

                <div class="r-home__destinations-wrap">

                    <div class="c-columns m-3-cols">

                        @foreach ($flights1 as $key => $flight1)

                            <div class="c-columns__item">

                                @include('component.destination', [
                                    'modifiers' => ['m-yellow', 'm-red', 'm-green'][$key],
                                    'title' =>
                                        $flight1->getDestination() ? $flight1->getDestination()->name : null,
                                    'title_route' =>
                                        $flight1->getDestination() ? route('destination.show', $flight1->getDestination()) : null,
                                    'subtitle' =>
                                        $flight1->getDestinationParent() ? $flight1->getDestinationParent()->name : null,
                                    'subtitle_route' =>
                                        $flight1->getDestinationParent() ? route('destination.show', $flight1->getDestinationParent()) : null
                                ])

                                @include('component.card', [
                                    'modifiers' => ['m-yellow', 'm-red', 'm-green'][$key],
                                    'route' => route('content.show', [$flight1->type, $flight1]),
                                    'title' => $flight1->title.' '.$flight1->price.' '.config('site.currency.symbol'),
                                    'image' => $flight1->imagePreset(),
                                ])

                            </div>

                        @endforeach

                    </div>
                    <div class="r-home__destinations-action">

                        @include('component.link', [
                            'modifiers' => 'm-icon m-right',
                            'title' => 'Vaata kõiki sooduspakkumisi',
                            'route' => route('content.show', ['flight']),
                            'icon' => 'icon-arrow-right'
                        ])

                    </div>
                </div>
            </div>

        @endif

        @if (isset($content) && ! empty($content->first()))

            <div class="r-home__about">

                <div class="r-home__about-wrap">

                    @include('component.about', [
                        'modifiers' => 'm-wide',
                        'title' => str_limit($content->first()->body, 300),
                        'links' => [
                            [
                                'modifiers' => 'm-icon',
                                'title' => trans('frontpage.index.about.title'),
                                'route' => route('content.show', [$content->first()->type, $content->first()]),
                                'icon' => 'icon-arrow-right'
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
                                'title' => trans('frontpage.index.forum.general'),
                                'route' => route('content.show', 'forum'),
                                'modifiers' => 'm-large m-block m-icon',
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'title' => trans('frontpage.index.forum.buysell'),
                                'route' => route('content.show', 'buysell'),
                                'modifiers' => 'm-large m-block m-icon',
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'title' => trans('frontpage.index.forum.expat'),
                                'route' => route('content.show', 'expat'),
                                'modifiers' => 'm-large m-block m-icon',
                                'icon' => 'icon-arrow-right'
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

                @if (isset($forums) && ! empty($forums))

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
                                    'tags' => $forum->topics->take(2)->transform(function ($topic, $key) use ($forum) {
                                        return [
                                            'title' => $topic->name,
                                            'modifiers' => ['m-green', 'm-blue', 'm-orange', 'm-yellow', 'm-red'][$key],
                                            'route' => route('content.show', [$forum->type]).'?topic='.$topic->id,
                                        ];
                                    })

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

                    @if (isset($news1) && ! empty($news1))

                        <div class="r-home__news-block-wrap">

                            @foreach($news1 as $key => $new)

                                <div class="r-home__news-block @if($key==0) m-first @else m-last @endif">

                                    @include('component.news', [
                                        'title' => $new->title,
                                        'route' => route('content.show', [$new->type, $new]),
                                        'date' => $new->created_at,
                                        'image' => $new->imagePreset(),
                                        'modifiers' => ($key==0?'':'m-small')
                                    ])

                                </div>

                            @endforeach

                        </div>

                    @endif


                    @if (isset($news2) && ! empty($news2))

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

                    <div class="r-home__news-footer">

                        @include('component.link', [
                            'title' => trans('frontpage.index.all.news'),
                            'route' => route('content.show', ['news']),
                            'modifiers' => 'm-icon m-right',
                            'icon' => 'icon-arrow-right'
                        ])

                    </div>
                </div>
            </div>
        </div>

        @if (isset($featured_news) && ! empty($featured_news))

            <div class="r-home__featured-news">

                <div class="r-home__featured-news-wrap">

                    <div class="c-columns m-3-cols">

                        @foreach ($featured_news as $featured_new)

                            <div class="c-columns__item">

                                @include('component.news', [
                                    'title' => $featured_new->title,
                                    'route' => route('content.show', [$featured_new->type, $featured_new]),
                                    'image' => $featured_new->imagePreset(),
                                    'modifiers' => 'm-smaller'
                                ])

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        @endif

        <div class="r-home__travel">

            <div class="r-home__travel-wrap">

                <div class="r-home__travel-column m-first">

                    <div class="r-home__travel-title">

                        @include('component.title', [
                            'modifiers' => 'm-red',
                            'title' => trans('frontpage.index.flight.title')
                        ])

                    </div>

                    @if (isset($flights2) && ! empty($flights2))

                        @foreach ($flights2 as $key => $flight2)

                            @include('component.row', [
                                'icon' => 'icon-tickets',
                                'modifiers' => ['m-blue', 'm-yellow', 'm-green', 'm-red', 'm-purple'][$key].' m-icon',
                                'title' => $flight2->title.' '.$flight2->price.' '.config('site.currency.symbol'),
                                'route' => route('content.show', [$flight2->type, $flight2]),
                                'text' =>
                                    view('component.date.short', ['date' => $flight2->end_at])
                                    .' / '.
                                    view('component.date.relative', ['date' => $flight2->created_at])
                            ])

                        @endforeach

                    @endif

                    <div class="r-home__travel-column-footer">

                        @include('component.link', [
                            'modifiers' => 'm-icon',
                            'title' => trans('frontpage.index.all.offers'),
                            'route' => route('content.show', ['flight']),
                            'icon' => 'icon-arrow-right'
                        ])

                    </div>

                </div>

                @if (isset($blogs) && ! empty($blogs))

                    <div class="r-home__travel-column m-last">

                        <div class="r-home__travel-title">

                            @include('component.title', [
                                'modifiers' => 'm-red',
                                'title' => trans('frontpage.index.travelletter.title')
                            ])

                        </div>

                        @foreach ($blogs as $blog)

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


        @if (isset($photos) && ! empty($photos))

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

        @if (isset($travelmates) && ! empty($travelmates))

            <div class="r-home__travel-mates">

                <div class="r-home__travel-mates-wrap">

                    <div class="r-home__travel-mates-title">

                        @include('component.title', [
                            'title' => trans('frontpage.index.travelmate.title'),
                            'modifiers' => 'm-red'
                        ])

                    </div>

                    <div class="c-columns m-4-cols">

                        @foreach ($travelmates as $travelmate)

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
