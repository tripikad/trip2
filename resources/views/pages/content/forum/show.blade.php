@extends('layouts.main')

@section('title', trans("content.$type.index.title"))

@section('head_image', \App\Image::getSocial())

@section('content')

<div class="r-forum m-single">

    <div class="r-forum__masthead">

        @include('component.forum.masthead')

        <div class="r-forum__map">

            <div class="r-forum__map-inner">

                @include('component.map', [
                    'modifiers' => 'm-forum'
                ])
            </div>
        </div>
    </div>

    <div class="r-forum__wrap">
        <div class="r-forum__content">

            @include('component.content.forum.post', [
                'profile' => [
                    'modifiers' => 'm-full m-status',
                    'image' => $content->user->imagePreset(),
                    'title' => $content->user->name,
                    'route' => ($content->user->name != 'Tripi külastaja' ? route('user.show', [$content->user]) : false),
                    'letter' => [
                        'modifiers' => 'm-purple m-small',
                        'text' => $content->user->name[0]
                    ],
                    'status' => [
                        'modifiers' => 'm-purple',
                        'position' => $content->user->rank,
                        'editor' => $content->user->role == 'admin'?true:false
                    ],
                ],
                'title' => $content->title,
                'date' => view('component.date.relative', ['date' => $content->created_at]),
                'date_edit' =>
                    $content->created_at != $content->updated_at ?
                        view('component.date.long', ['date' => $content->updated_at])
                    : null,
                'text' => $content->body_filtered,
                'actions' => view('component.actions', ['actions' => $content->getActions()]),
                'thumbs' => view('component.flags', ['flags' => $content->getFlags()]),
                'tags' => $content->destinations->transform(function ($destination) {
                    return [
                        'modifiers' => 'm-yellow',
                        'title' => $destination->name,
                        'route' => route('destination.showSlug', $destination->slug)
                    ];
                }),
                'tags2' => $content->topics->transform(function ($topic) {
                    return [
                        'modifiers' => 'm-gray',
                        'title' => $topic->name,
                        'route' => ''
                    ];
                })
            ])

            @if ($comments->count())
                <a href="{{ route($content->type.'.show', [$content->slug]) . ($comments->lastPage() > 1 ? '?page=' . $comments->lastPage() : '') . '#comment-' . $comments->last()->id }}" class="m-center m-medium-offset-bottom">{{ trans('comment.action.latest.comment') }}</a>
            @endif

            @if ($comments->perPage() < $comments->total())

                <div class="r-block m-small">
                    @include('component.pagination.numbered', [
                        'collection' => $comments
                    ])
                </div>

            @endif

            @if (method_exists($comments, 'currentPage'))

                @include('component.comment.index', [
                    'comments' => $comments->forPage(
                        $comments->currentPage(),
                        $comments->perPage()
                    )
                ])
            @endif

            <?php //dd($comments->last());
            ?>

            @if ($comments->perPage() < $comments->total())

                <div class="r-block m-small">
                    @include('component.pagination.numbered', [
                        'collection' => $comments
                    ])
                </div>

            @endif

            @if (\Auth::check())

            <div class="r-block">

                <div class="r-block__inner">

                    <div class="r-block__header">

                        <div class="r-block__header-title">

                            @include('component.title', [
                                'title' => 'Lisa kommentaar',
                                'modifiers' => 'm-large m-green'
                            ])
                        </div>
                    </div>

                    <div class="r-block__body">

                        @include('component.comment.create')
                    </div>
                </div>
            </div>

            @endif

        </div>

        <div class="r-forum__sidebar">

            <div class="r-block m-small m-flex">

                @include('component.content.forum.nav', [
                    'items' => [
                        [
                            'title' => trans('frontpage.index.forum.general'),
                            'route' => route('forum.index'),
                            'modifiers' => 'm-large m-block m-icon',
                            'icon' => 'icon-arrow-right'
                        ],
                        [
                            'title' => trans('frontpage.index.forum.buysell'),
                            'route' => route('buysell.index'),
                            'modifiers' => 'm-large m-block m-icon',
                            'icon' => 'icon-arrow-right'
                        ],
                        [
                            'title' => trans('frontpage.index.forum.expat'),
                            'route' => route('expat.index'),
                            'modifiers' => 'm-large m-block m-icon',
                            'icon' => 'icon-arrow-right'
                        ],

                    ]
                ])

                @if (\Auth::check())

                    @include('component.content.forum.nav', [
                        'items' => [
                            [
                                'type' => 'button',
                                'title' => trans("content.$type.create.title"),
                                'route' => route('content.create', ['type' => $type]),
                                'modifiers' => 'm-secondary m-block m-shadow'
                            ]
                        ]
                    ])

                @endif

            </div>

            @if (count($first_relative_posts))

                <div class="r-block m-small">

                    @if ($first_destination)

                        @include('component.destination', [
                            'modifiers' => 'm-purple',
                            'title' => $first_destination->name,
                            'title_route' => route('destination.showSlug', [
                                $first_destination->slug
                            ]),
                            'subtitle' => $first_destination_parent ? $first_destination_parent->name : null,
                            'subtitle_route' => $first_destination_parent ? route('destination.showSlug', [
                                $first_destination_parent->slug
                            ]) : null
                        ])

                    @endif

                    <div class="r-block__inner">

                        <div class="r-block__header">

                            <div class="r-block__header-title m-flex">

                                @include('component.title', [
                                    'modifiers' => 'm-purple',
                                    'title' => trans('destination.show.forum.title')
                                ])
                            </div>
                        </div>

                        <div class="r-block__body">

                            @include('component.content.forum.list', [
                                'modifiers' => 'm-compact',
                                'items' => $first_relative_posts->transform(function ($post) {
                                    return [
                                        'topic' => str_limit($post->title, 25),
                                        'route' => route($post->type.'.show', [$post->slug]),
                                        'profile' => [
                                            'modifiers' => 'm-mini',
                                            'image' => $post->user->imagePreset(),
                                            'letter' => [
                                                'modifiers' => 'm-green m-small',
                                                'text' => 'D'
                                            ],
                                        ],
                                        'badge' => [
                                            'modifiers' => 'm-inverted m-purple',
                                            'count' => $post->comments->count()
                                        ]
                                    ];
                                })
                            ])
                        </div>
                    </div>
                </div>

            @endif

            <div class="r-block m-small m-mobile-hide">

                @include('component.promo', ['promo' => 'sidebar_small'])

            </div>

            @if (count($second_relative_posts))

                <div class="r-block m-small">

                    @if ($second_destination)

                        @include('component.destination', [
                            'modifiers' => 'm-blue',
                            'title' => $second_destination->name,
                            'title_route' => route('destination.showSlug', [
                                $second_destination->slug
                            ]),
                            'subtitle' => $second_destination_parent ? $second_destination_parent->name : null,
                            'subtitle_route' => $second_destination_parent ? route('destination.showSlug', [
                                $second_destination_parent->slug
                            ]) : null
                        ])

                    @endif

                    <div class="r-block__inner">

                        <div class="r-block__header">

                            <div class="r-block__header-title m-flex">

                                @include('component.title', [
                                    'modifiers' => 'm-purple',
                                    'title' => trans('destination.show.forum.title')
                                ])
                            </div>
                        </div>

                        <div class="r-block__body">

                            @include('component.content.forum.list', [
                                'modifiers' => 'm-compact',
                                'items' => $second_relative_posts->transform(function ($post) {
                                    return [
                                        'topic' => str_limit($post->title, 25),
                                        'route' => route($post->type.'.show', [$post->slug]),
                                        'profile' => [
                                            'modifiers' => 'm-mini',
                                            'image' => $post->user->imagePreset(),
                                            'letter' => [
                                                'modifiers' => 'm-green m-small',
                                                'text' => 'D'
                                            ],
                                        ],
                                        'badge' => [
                                            'modifiers' => 'm-inverted m-blue',
                                            'count' => $post->comments->count()
                                        ]
                                    ];
                                })
                            ])
                        </div>
                    </div>
                </div>

            @endif

            <div class="r-block m-small m-mobile-hide">

                @include('component.promo', ['promo' => 'sidebar_large'])

            </div>

            @if (count($relative_flights))

                <div class="r-block m-small">

                    @foreach ($relative_flights as $flight)
                        @include('component.card', [
                            'route' => route($flight->type.'.show', [$flight->slug]),
                            'title' => $flight->title.' '.$flight->price.' '.config('site.currency.symbol'),
                            'image' => $flight->imagePreset()
                        ])
                    @endforeach

                </div>

            @endif

        </div>
    </div>

    @if (count($forums) || count($travel_mates) || count($flights))

        <div class="r-forum__additional">
            <div class="r-forum__additional-wrap">

                @if (count($forums))

                    <div class="r-block">
                        <div class="r-block__header">

                            @include('component.title', [
                                'modifiers' => 'm-red',
                                'title' => trans('destination.show.forum.title')
                            ])

                        </div>
                        <div class="r-forum__additional-column m-first">

                            @include('component.content.forum.nav', [
                                'items' => [
                                    [
                                        'title' => trans('frontpage.index.forum.general'),
                                        'route' => route('forum.index'),
                                        'modifiers' => 'm-large m-block m-icon',
                                        'icon' => 'icon-arrow-right'
                                    ],
                                    [
                                        'title' => trans('frontpage.index.forum.buysell'),
                                        'route' => route('buysell.index'),
                                        'modifiers' => 'm-large m-block m-icon',
                                        'icon' => 'icon-arrow-right'
                                    ],
                                    [
                                        'title' => trans('frontpage.index.forum.expat'),
                                        'route' => route('expat.index'),
                                        'modifiers' => 'm-large m-block m-icon',
                                        'icon' => 'icon-arrow-right'
                                    ]
                                ]
                            ])

                        </div>
                        <div class="r-forum__additional-column m-last">

                            @include('component.content.forum.list', [
                                'items' => $forums->transform(function ($forum) {
                                    return [
                                        'topic' => str_limit($forum->title, 50),
                                        'route' => route($forum->type.'.show', [$forum->slug]),
                                        'date' => view('component.date.relative', [
                                            'date' => $forum->created_at
                                        ]),
                                        'profile' => [
                                            'modifiers' => 'm-mini',
                                            'image' => $forum->user->imagePreset(),
                                            'letter' => [
                                                'modifiers' => 'm-green m-small',
                                                'text' => 'D'
                                            ],
                                        ],
                                        'badge' => [
                                            'modifiers' => 'm-inverted',
                                            'count' => $forum->comments->count()
                                        ],
                                        'tags' => $forum->destinations->merge($forum->topics)->take(2)->transform(function ($destination, $key) use ($forum) {
                                            return [
                                                'title' => $destination->name,
                                                'modifiers' => ['m-gray', 'm-green', 'm-blue', 'm-orange', 'm-yellow', 'm-red'][$key],
                                                'route' => route($forum->type.'.index').'?topic='.$destination->id,
                                            ];
                                        })
                                    ];
                                })
                            ])
                        </div>
                    </div>

                @endif

                @if (count($flights))

                    <div class="r-block">
                        <div class="c-columns m-{{ count($flights) }}-cols">

                            @foreach ($flights as $flight)

                                <div class="c-columns__item">

                                    @include('component.card', [
                                        'route' => route($flight->type.'.show', [$flight->slug]),
                                        'title' => $flight->title.' '.$flight->price.' '.config('site.currency.symbol'),
                                        'image' => $flight->imagePreset()
                                    ])

                                </div>

                            @endforeach

                        </div>
                    </div>

                @endif

                @if (count($travel_mates))

                    <div class="r-block m-no-margin">
                        <div class="r-block__header">
                            @include('component.title', [
                                'title' => trans('frontpage.index.travelmate.title'),
                                'modifiers' => 'm-red'
                            ])
                        </div>

                        @include('component.travelmate.list', [
                            'modifiers' => 'm-'.count($travel_mates).'col',
                            'items' => $travel_mates->transform(function ($travel_mate) {
                                return [
                                    'modifiers' => 'm-small',
                                    'image' =>  $travel_mate->imagePreset(),
                                    'letter'=> [
                                        'modifiers' => 'm-red',
                                        'text' => 'J'
                                    ],
                                    'name' =>
                                        $travel_mate->user->real_name ?
                                            $travel_mate->user->real_name
                                        :
                                            $travel_mate->user->name,
                                    'route' => route($travel_mate->type.'.show', [$travel_mate->slug]),
                                    'sex_and_age' =>
                                        ($travel_mate->user->gender ?
                                            trans('user.gender.'.$travel_mate->user->gender).
                                            ($travel_mate->user->age ? ', ' : '')
                                        : null).
                                        ($travel_mate->user->age ? $travel_mate->user->age : null),
                                    'title' => $travel_mate->title,
                                    'tags' => $travel_mate->destinations->transform(function ($destination) {
                                        return [
                                            'modifiers' => ['m-purple', 'm-yellow', 'm-red', 'm-green'][rand(0,3)],
                                            'title' => $destination->name
                                        ];
                                    })
                                ];
                            })
                        ])

                    </div>

                @endif

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
