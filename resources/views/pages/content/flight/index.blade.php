@extends('layouts.main')

@section('title', trans("content.$type.index.title"))

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('content')

<div class="r-flights">

    <div class="r-flights__masthead">
        @include('component.masthead', [
            'modifiers' => 'm-alternative',
            'image' => \App\Image::getHeader()
        ])
    </div>

    <div class="r-flights__content-wrap">
        <div class="r-flights__content">

            @if (count($contents))
                @include('component.content.flight.block', [
                    'items' => $contents->take(4)->transform(function ($content) {
                        $content->destinations->push(['name' => $content->created_at]);

                        return [
                            'image' => $content->imagePreset('medium'),
                            'route' => route('content.show', [$content->type, $content]),
                            'title' => $content->title,
                            'price' => trans('content.flight.index.from').' '.$content->price.config('site.currency.symbol'),
                            'meta' => view('component.inline_list', [
                                'modifiers' => 'm-light m-small',
                                'items' => $content->destinations->transform(function ($content_destination, $key) {
                                    $item = [
                                        'title' => (isset($content_destination->name) ?
                                            $content_destination->name :
                                            view('component.date.relative', ['date' => $content_destination['name']]))
                                    ];

                                    return $item;
                                })
                            ]),
                        ];
                    })
                ])
            @else
                <div class="m-small-offset-bottom">
                    @include('component.card', [
                        'text' => (isset($destination) ?
                            trans('content.flight.filter.no.results') :
                            trans('content.flight.no.results')),
                        'modifiers' => 'm-red',
                    ])
                </div>
            @endif

            @include('component.promo', ['promo' => 'body m-margin'])

            @if (count($contents) > 4)
                @include('component.content.flight.block', [
                    'items' => $contents->splice(4)->transform(function ($content) {
                        $content->destinations->push(['name' => $content->created_at]);

                        return [
                            'image' => $content->imagePreset('medium'),
                            'route' => route('content.show', [$content->type, $content]),
                            'title' => $content->title,
                            'price' => trans('content.flight.index.from').' '.$content->price.config('site.currency.symbol'),
                            'meta' => view('component.inline_list', [
                                'modifiers' => 'm-light m-small',
                                'items' => $content->destinations->transform(function ($content_destination, $key) {
                                    $item = [
                                        'title' => (isset($content_destination->name) ?
                                            $content_destination->name :
                                            view('component.date.relative', ['date' => $content_destination['name']]))
                                        ];

                                    return $item;
                                })
                            ]),
                        ];
                    })
                ])
            @endif

            @include('component.pagination.default', [
                'collection' => $contents,
                'text' => [
                    'next' => trans('content.flight.action.next'),
                    'previous' => trans('content.flight.action.previous'),
                ]
            ])

        </div>

        <div class="r-flights__sidebar">
            <div class="r-block m-small">
                <div class="r-block__inner">
                    @include('component.filter')
                </div>
            </div>

            <div class="r-block m-small">
                <div class="r-block__inner">

                    @include('component.about', [
                        'title' => trans('content.flight.index.about.title'),
                        'text' => trans('content.flight.index.about.text'),
                        'links' => [
                            [
                                'modifiers' => 'm-icon',
                                'title' => trans('content.action.more.about'),
                                'route' =>
                                    count($about) ?
                                        route('content.show', [$about->first()->type, $about->first()])
                                    : null,
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'modifiers' => 'm-icon',
                                'title' => trans('content.action.price.error'),
                                'route' => route('content.show', ['static', 97203]),
                                'icon' => 'icon-arrow-right'
                            ]
                        ],
                        'button' =>
                        \Auth::check() && \Auth::user()->hasRole('admin') ? [
                            'modifiers' => 'm-block',
                            'route' => route('content.create', ['type' => $type]),
                            'title' => trans("content.$type.create.title")
                        ] : null
                    ])
                </div>
            </div>

            @include('component.promo', ['promo' => 'sidebar_large m-small-margin '])

            @include('component.promo', ['promo' => 'sidebar_small m-small-margin '])

            @if (isset($about) && count($about))
                <div class="r-block m-small">
                    <div class="r-block__inner">
                        @include('component.about', [
                            'title' => trans('content.action.more.about.text'),
                            'links' => [
                                [
                                    'modifiers' => 'm-icon',
                                    'title' => trans('content.action.more.about'),
                                    'route' => route('content.show', [$about->first()->type, $about->first()]),
                                    'icon' => 'icon-arrow-right'
                                ],
                                [
                                    'modifiers' => 'm-icon',
                                    'title' => trans('content.action.facebook.text'),
                                    'route' => config('menu.footer-social.facebook.route'),
                                    'icon' => 'icon-arrow-right'
                                ],
                                [
                                    'modifiers' => 'm-icon',
                                    'title' => trans('content.action.twitter.text'),
                                    'route' => config('menu.footer-social.twitter.route'),
                                    'icon' => 'icon-arrow-right'
                                ]
                            ],
                            'button' =>
                                !\Auth::check() ? [
                                    'modifiers' => 'm-block',
                                    'route' => route('register.form'),
                                    'title' => trans('content.action.register')
                                ] : null
                        ])
                    </div>
                </div>
            @endif

        </div>
    </div>

    <div class="r-flights__forum">
        <div class="r-flights__forum-wrap">
            <div class="r-flights__forum-title m-first">
                @include('component.title', [
                    'modifiers' => 'm-red',
                    'title' => trans('content.forum.sidebar.title')
                ])
            </div>

            <div class="r-flights__forum-column m-first">
                @include('component.content.forum.nav', [
                    'items' => config('menu.'.config('content_forum.menu')),
                ])
            </div>

            @if (isset($forums) && count($forums) > 0)
                <div class="r-flights__forum-column m-last">
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

    <div class="r-flights__footer-promo">
        <div class="r-flights__footer-promo-wrap">
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
