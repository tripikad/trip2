@extends('layouts.main')

@section('title', trans("content.$type.index.title"))

@section('head_description', trans('site.description.flight'))

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

            <div id="mmd-flight-widget" class="m-large-offset-bottom" style="width: 100%; display: inline-block; min-height: 215px;"></div>
            <script type="text/javascript">
                (function initWidget(options)
                {
                    var settings = options.settings;
                    var airports = options.airports;
                    var encoding = '';
                    onFlightWidgetLoaded = function (f)
                    {
                        f('mmd-flight-widget', {
                            searchForms: [{
                                type: 1,
                                searchURL: 'http://[DOMAIN]/flightsearch/[QUERY]' + (!!settings.source ? '&source=' + settings.source : '') +"&utm_source=tripee&utm_medium=affiliate&utm_campaign=widget",
                                openNewWindow: settings.openNewWindow,
                                currency: "EUR",
                                segments: [
                                    {
                                        airports: [
                                            { code: airports.origin || '' },
                                            { code: airports.destination || '' }
                                        ]
                                    },
                                    {
                                        airports: [
                                            { code: airports.destination || '' },
                                            { code: airports.origin || '' }
                                        ]
                                    }
                                ]
                            }]
                        });
                    };
                    var scr = document.createElement('script');
                    scr['src'] = 'http://' + settings.domain + '/widget/searchform/v1.1/?encoding=' + encoding + '&dimensions=generic&types=1&callback=onFlightWidgetLoaded';
                    var tag = document.getElementsByTagName('head');
                    if (tag &&
                            tag.length)
                    {
                        tag = tag[0];
                        tag.appendChild(scr);
                    }
                })(
                        {
                            airports: {
                                origin: '',
                                destination: ''
                            },
                            settings: {
                                openNewWindow: true,
                                domain: 'www.momondo.ee',
                                source: ''
                            }
                        }
                );
            </script>

            @if (count($contents))
                @include('region.content.flight.list', [
                    'items' => $contents->take(8)
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

            @if (count($contents) > 8)
                @include('region.content.flight.list', [
                    'items' => $contents->splice(8)
                ])
            @endif

            @include('component.pagination.default', [
                'collection' => $contents,
                'text' => [
                    'next' => trans('content.flight.action.next'),
                    'previous' => trans('content.flight.action.previous'),
                ]
            ])

            <div class="m-large-offset-top" style="width: 100%; display:inline-block;">
                <script src="https://www.hotelscombined.ee/SearchBox/364585"></script>
            </div>
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
                                        route('static.'.$about->first()->id)
                                    : null,
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'modifiers' => 'm-icon',
                                'title' => trans('content.action.price.error'),
                                'route' => route('static.show', [97203]),
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
                                    'route' => route('static.'.$about->first()->id),
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
