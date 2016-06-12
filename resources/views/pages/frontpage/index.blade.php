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
            'image' => \App\Image::getHeader()
        ])
        </div>

        @if (isset($flights1) && count($flights1))
            <div class="r-home__destinations">
                <div class="r-home__destinations-wrap">
                    <div class="c-columns m-{{ count($flights1) }}-cols">
                        @foreach ($flights1 as $key => $flight1)
                            <div class="c-columns__item">
                                @include('component.destination', [
                                    'modifiers' => ['m-purple', 'm-yellow', 'm-red'][$key],
                                    'title' =>
                                        $flight1->destination ? $flight1->destination->name : null,
                                    'title_route' =>
                                        $flight1->destination ? route('destination.show', $flight1->destination) : null,
                                    'subtitle' =>
                                        $flight1->parent_destination ? $flight1->parent_destination->name : null,
                                    'subtitle_route' =>
                                        $flight1->parent_destination ? route('destination.show', $flight1->parent_destination) : null
                                ])

                                @include('component.card', [
                                    'modifiers' => ['m-purple', 'm-yellow', 'm-red'][$key],
                                    'route' => route('content.show', [$flight1->type, $flight1]),
                                    'title' => $flight1->title.' '.$flight1->price.config('site.currency.symbol'),
                                    'image' => $flight1->imagePreset(),
                                ])
                            </div>
                        @endforeach
                    </div>
                    <div class="r-home__destinations-action">
                        @include('component.link', [
                            'modifiers' => 'm-icon m-right',
                            'title' => trans('frontpage.index.all.offers'),
                            'route' => route('content.index', ['flight']),
                            'icon' => 'icon-arrow-right'
                        ])
                    </div>
                </div>
            </div>
        @endif

        @if (isset($content) && count($content) > 0)
            <div class="r-home__about">
                <div class="r-home__about-wrap">
                    @include('component.about', [
                        'modifiers' => 'm-wide',
                        'title' => trans('content.action.more.about.text'),
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
                                'route' => route('content.index', 'forum'),
                                'modifiers' => 'm-large m-block m-icon',
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'title' => trans('frontpage.index.forum.buysell'),
                                'route' => route('content.index', 'buysell'),
                                'modifiers' => 'm-large m-block m-icon',
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'title' => trans('frontpage.index.forum.expat'),
                                'route' => route('content.index', 'expat'),
                                'modifiers' => 'm-large m-block m-icon',
                                'icon' => 'icon-arrow-right'
                            ],
                            (Auth::check() ? [
                                'type' => 'button',
                                'title' => trans('frontpage.index.forum.create'),
                                'route' => route('content.create', ['forum']),
                                'modifiers' => 'm-secondary m-block m-shadow'
                            ] : [])
                        ]
                    ])
                </div>

                @if (isset($forums) && count($forums) > 0)
                    <div class="r-home__forum-column m-last">
                        @include('region.content.forum.list', [
                            'items' => $forums,
                            'tags' => [
                                'take' => 2,
                            ],
                        ])
                    </div>
                @endif
            </div>
        </div>

        <div class="r-home__news">
            <div class="r-home__news-wrap">
                <div class="r-home__news-column m-first">
                    <div class="r-block m-small">

                        @include('component.promo', ['promo' => 'sidebar_large'])

                    </div>
                    <div class="r-block m-small">

                        @include('component.promo', ['promo' => 'sidebar_small'])

                    </div>
                </div>
                <div class="r-home__news-column m-last">
                    <div class="r-home__news-title">

                        @include('component.title', [
                            'modifiers' => 'm-red',
                            'title' => trans('frontpage.index.news.title')
                        ])

                    </div>

                    @if (isset($news) && count($news) > 0)
                        <div class="r-home__news-block-wrap">
                        @foreach ($news as $key => $new)
                            <div class="r-home__news-block @if(($key + 1) % 2 == 0) m-last @else m-first @endif">
                                @include('component.news', [
                                    'title' => $new->title,
                                    'route' => route('content.show', [$new->type, $new]),
                                    'date' => $new->created_at,
                                    'image' => $new->imagePreset(),
                                    'modifiers' => $key > 3 ? 'm-smaller' : null
                                ])
                            </div>

                            @if (($key + 1) % 2 == 0)
                                </div>
                                <div class="r-home__news-block-wrap">
                            @endif

                        @endforeach
                        </div>
                    @endif

                    <div class="r-home__news-footer">
                        <div class="r-block">
                            @include('component.link', [
                                'title' => trans('frontpage.index.all.news'),
                                'route' => route('content.index', ['news']),
                                'modifiers' => 'm-icon m-right',
                                'icon' => 'icon-arrow-right'
                            ])
                        </div>
                    </div>
                   @include('component.promo', ['promo' => 'body'])
                </div>
            </div>
        </div>

        @if (isset($featured_news) && count($featured_news) > 0)
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
                @if (isset($flights2) && count($flights2) > 0)
                    <div class="r-home__travel-column m-first">
                        <div class="r-home__travel-title">
                            @include('component.title', [
                                'modifiers' => 'm-red',
                                'title' => trans('frontpage.index.flight.title')
                            ])
                        </div>

                        @include('region.content.flight.list', [
                            'items' => $flights2
                        ])

                        <div class="r-block__footer">
                            @include('component.link', [
                                'modifiers' => 'm-icon m-right',
                                'title' => trans('frontpage.index.all.offers'),
                                'route' => route('content.index', ['flight']),
                                'icon' => 'icon-arrow-right'
                            ])
                        </div>
                    </div>
                @endif

                @if (isset($blogs) && count($blogs) > 0)
                    @if (isset($flights2) && count($flights2) > 0)
                    <div class="r-home__travel-column m-last">
                    @else
                    <div class="r-home__travel-column m-single">
                    @endif

                        <div class="r-home__travel-title">
                            @include('component.title', [
                                'modifiers' => 'm-red',
                                'title' => trans('frontpage.index.travelletter.title')
                            ])
                        </div>

                        @foreach ($blogs as $blog)
                            @include('component.blog', [
                                'title' => $blog->title,
                                'image' => '',
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


        @if (isset($photos) && count($photos) > 0)
            <div class="r-home__gallery">
                <div class="r-home__gallery-wrap">
                    <div class="r-home__gallery-title">
                        <div class="r-home__gallery-title-wrap">
                            @include('component.title', [
                                'modifiers' => 'm-red',
                                'title' => trans('frontpage.index.photo.title')
                            ])
                        </div>
                    </div>

                    @include('component.gallery', [
                        'modal' => [
                            'modifiers' => 'm-yellow',
                        ],
                        'items' => $photos->transform(function ($photo) {
                            return [
                                'image' => $photo->imagePreset('small'),
                                'image_large' => $photo->imagePreset('large'),
                                'route' => route('content.show', [$photo->type, $photo]),
                                'alt' => $photo->title,
                                'tags' => $photo->destinations->transform(function($destination) {
                                    return [
                                        'title' => $destination->name,
                                        'modifiers' => ['m-orange', 'm-red', 'm-yellow', 'm-blue'][rand(0,3)],
                                        'route' => route('destination.show', $destination)
                                    ];
                                })
                            ];
                        })
                    ])
                </div>
            </div>
        @endif

        @if (isset($travelmates) && count($travelmates) > 0)
            <div class="r-home__travel-mates">
                <div class="r-home__travel-mates-wrap">
                    <div class="r-home__travel-mates-title">
                        @include('component.title', [
                            'title' => trans('frontpage.index.travelmate.title'),
                            'modifiers' => 'm-red'
                        ])
                    </div>
                    @include('region.content.travelmate.list', [
                        'items' => $travelmates
                    ])
                </div>
            </div>
        @endif

        <div class="r-home__footer-promo">
            <div class="r-home__footer-promo-wrap">
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
