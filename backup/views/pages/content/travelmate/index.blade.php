@extends('layouts.main')

@section('title', trans("content.$type.index.title"))

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('content')

<div class="r-travelmates">

    <div class="r-travelmates__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-alternative',
            'image' => \App\Image::getRandom(),
            'subtitle' => trans('content.travelmate.activity', [
                'days' => 14,
                'posts_count' => $activity
            ])
        ])

    </div>

    <div class="r-travelmates__wrap">

        <div class="r-travelmates__filter">

            @include('component.range_filter')

        </div>

        <div class="r-travelmates__content">

            @if (count($contents))

                @include('component.travelmate.list', [
                    'modifiers' => 'm-2col',
                    'items' => $contents->take(8)->transform(function ($content) {
                        return [
                            'modifiers' => '',
                            'image' =>  $content->user->imagePreset('small_square'),
                            'letter'=> [
                                'modifiers' => 'm-red',
                                'text' => 'J'
                            ],
                            'name' => $content->user->name,
                            'route' => route($item->type.'.show', [$item->slug]),
                            'sex_and_age' =>
                                ($content->user->gender ?
                                    trans('user.gender.'.$content->user->gender).
                                    ($content->user->age ? ', ' : '')
                                : null).
                                ($content->user->age ? $content->user->age : null),
                            'title' => $content->title,
                            'tags' => $content->destinations->transform(function ($content_destination) {
                                return [
                                    'modifiers' => ['m-purple', 'm-yellow', 'm-red', 'm-green'][rand(0,3)],
                                    'title' => $content_destination->name
                                ];
                            })
                        ];
                    })
                ])

            @endif

            <div class="r-block m-small m-mobile-hide">

                @include('component.promo', ['promo' => 'body'])

            </div>

            @if (count($contents) > 8)

                @include('component.travelmate.list', [
                    'modifiers' => 'm-2col',
                    'items' => $contents->splice(8)->transform(function ($content) {
                        return [
                            'modifiers' => '',
                            'image' => $content->user->imagePreset('small_square'),
                            'letter'=> [
                                'modifiers' => 'm-red',
                                'text' => 'J'
                            ],
                            'name' => $content->user->name,
                            'route' => route('content.show', [$content->type, $content]),
                            'sex_and_age' =>
                                ($content->user->gender ?
                                    trans('user.gender.'.$content->user->gender).
                                    ($content->user->age ? ', ' : '')
                                : null).
                                ($content->user->age ? $content->user->age : null),
                            'title' => $content->title,
                            'tags' => $content->destinations->transform(function ($content_destination) {
                                return [
                                    'modifiers' => ['m-purple', 'm-yellow', 'm-red', 'm-green'][rand(0,3)],
                                    'title' => $content_destination->name
                                ];
                            })
                        ];
                    })
                ])

            @endif

            @include('component.pagination.default',[
                'collection' => $contents
            ])
        </div>

        <div class="r-travelmates__sidebar">

            <div class="r-block m-small">

                <div class="r-block__inner">

                    @include('component.about', [
                        'title' => trans('content.travelmate.description.title'),
                        'text' => trans('content.travelmate.description.text'),
                        'links' => count($rules) ? [
                            [
                                'modifiers' => 'm-icon',
                                'title' => $rules->first()->title,
                                'route' => route('content.show', [$rules->first()->type, $rules->first()]),
                                'icon' => 'icon-arrow-right'
                            ],
                        ] : null,
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

                    @include('component.travelmate.filter')
                </div>
            </div>

            <div class="r-block m-small m-mobile-hide">

                @include('component.promo', ['promo' => 'sidebar_small'])

            </div>

            <div class="r-block m-small">

                <div class="r-block__inner">

                    @include('component.about', [
                        'title' => count($about) ? str_limit($about->first()->body_filtered, 300) : null,
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
        </div>
    </div>

    <div class="r-travelmates__footer-promo">

        <div class="r-travelmates__footer-promo-wrap">

            @include('component.promo', ['promo' => 'footer'])

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
