@extends('layouts.main')

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
            'modifiers' => 'm-search'
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
                                'route' => route('content.show', ['flight', $flight1->id]),
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
                    'link' => [
                        'title' => trans('frontpage.index.about.title'),
                        'route' => route('content.show', ['static', $content->id]),
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

                @include('component.link', [
                    'modifiers' => 'm-large m-block',
                    'title' => 'Üldfoorum',
                    'route' => ''
                ])

                @include('component.link', [
                    'modifiers' => 'm-large m-block',
                    'title' => 'Ost-müük',
                    'route' => ''
                ])

                @include('component.link', [
                    'modifiers' => 'm-large m-block',
                    'title' => 'Vaba teema',
                    'route' => ''
                ])

                @include('component.button', [
                    'modifiers' => 'm-secondary m-block',
                    'title' => 'Otsi foorumist',
                    'route' => ''
                ])

                @include('component.button', [
                    'modifiers' => 'm-secondary m-block',
                    'title' => 'Alusta teemat',
                    'route' => ''
                ])

            </div>
            @if(isset($forums) && !empty($forums))
                <div class="r-home__forum-column m-last">

                    @foreach($forums as $name => $forum)

                        @include('component.content.forum.list', [
                            'container' => ($name==0&&count($forums)-1!=$name?'open':($name==count($forums)-1&&$name!=0?'close':($name==0?'both':''))),
                            'items' => [
                                [
                                    'topic' => str_limit($forum->title, 50),
                                    'route' => route('content.show', ['forum', $forum->id]),
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
                                ]
                            ]
                        ])

                    @endforeach

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
                                'route' => route('content.show', ['news', $new->id]),
                                'date' => $new->created_at,
                                'image' => $new->imagePreset(),
                                'modifiers' => ($name==0?'':'m-small')
                            ])

                        </div>

                    @endforeach

                </div>

                @endif


                @if(isset($news2) && !empty($news2))

                    @foreach($news2 as $name => $new)

                        @include('component.list', [
                            'container' => ($name==0&&count($news2)-1!=$name?'open':($name==count($news2)-1&&$name!=0?'close':($name==0?'both':''))),
                            'items' => [
                                [
                                    'title' => $new->title,
                                    'route' => route('content.show', ['news', $new->id]),
                                    'text' => view('component.date.short', ['date' => $new->created_at])
                                ]
                            ]
                        ])

                    @endforeach

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
                            'route' => route('content.show', ['flight', $flight2->id]),
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

            @if(isset($travelletters) && !empty($travelletters))
            <div class="r-home__travel-column m-last">

                <div class="r-home__travel-title">

                    @include('component.title', [
                        'modifiers' => 'm-red',
                        'title' => trans('frontpage.index.travelletter.title')
                    ])

                </div>

                @foreach($travelletters as $travelletter)

                    @include('component.blog', [
                        'title' => $travelletter->title,
                        'image' => $travelletter->imagePreset(),
                        'route' => route('content.show', ['blog', $travelletter->id]),
                        'profile' => [
                            'route' => route('user.show', [$travelletter->user]),
                            'title' => $travelletter->user->name,
                            'image' => $travelletter->user->imagePreset()
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

            @foreach($photos as $name => $photo)

                @include('component.gallery', [
                    'container' => ($name==0&&count($photos)-1!=$name?'open':($name==count($photos)-1&&$name!=0?'close':($name==0?'both':''))),
                    'items' => [
                        [
                            'image' => $photo->imagePreset(),
                            'route' => route('content.show', ['photo', $photo->id]),
                            'alt' => $photo->title
                        ]
                    ]
                ])

            @endforeach

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
                            'route' => route('content.show', ['travelmate', $travelmate->id]),
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
