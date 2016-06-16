@extends('layouts.main')

@section('title', trans("content.$type.index.title"))

@section('head_title',  $content->getHeadTitle())

@section('head_description', $content->getHeadDescription())

@section('head_image', $content->getHeadImage())

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('content')

<div class="r-flights m-single">

    <?php /*Will be hidden until there is a functionality to show the flight path

    <div class="r-flights__map">
        <div class="r-flights__map-inner">
            @include('component.map', [
                'modifiers' => 'm-flights'
            ])
        </div>
    </div>

    */ ?>

    <div class="r-flights__masthead">
        @include('component.masthead', [
            'modifiers' => 'm-alternative',
            'route' => route('content.index', [$content->type]),
            'subtitle' => trans('content.flight.show.action.all'),
            'subtitle_route' => route('content.index', [$content->type]),
            'image' => ($content->imagePreset('large') ?
                $content->imagePreset('large') :
                \App\Image::getHeader())
        ])
    </div>

    <div class="r-flights__content-wrap">
        <div class="r-flights__content">
            <div class="r-block">
                <div class="r-block__header">
                    <div class="r-block__header-title">
                        @include('component.title', [
                            'modifiers' => 'm-larger',
                            'title' => $content->title
                        ])
                    </div>

                    <div class="r-flights__content-header-meta">
                        <div class="r-flights__content-header-meta-item">
                            <ul class="c-inline-list m-light m-small">
                                @include('component.content.text', [
                                    'without_wrapper' => true,
                                    'content' => $content
                                ])
                                @include('component.actions.list', ['actions' => $content->getActions()])
                            </ul>
                        </div>
                        <div class="r-flights__content-header-meta-item">
                            @include('component.flags', ['flags' => $content->getFlags()])
                        </div>
                    </div>

                    @if (strtotime($content->end_at) < strtotime(Carbon\Carbon::now()))
                        @include('component.alert', [
                            'modifiers' => 'm-warning',
                            'text' => trans('content.flight.show.expired'),
                        ])
                    @endif

                </div>

                <div class="r-block__body">
                    <div class="c-body">
                        {!! $content->body_filtered !!}
                    </div>
                </div>
            </div>

            <div class="r-block">
                <div class="r-block__inner">
                    <div class="r-block__header">
                        <div class="r-block__header-title">
                            @include('component.title', [
                                'title' => trans('content.share.post.title'),
                                'modifiers' => 'm-large m-green'
                            ])
                        </div>
                    </div>

                    <div class="r-block__body">
                        @include('component.facebook')
                    </div>
                </div>
            </div>

            @include('component.promo', ['promo' => 'body m-margin'])

            @if (isset($flights) && count($flights))
                <div class="r-block">
                    <div class="r-block__header">
                        <div class="r-block__header-title">
                            @include('component.title', [
                                'modifiers' => 'm-green',
                                'title' => trans('frontpage.index.flight.title')
                            ])
                        </div>
                    </div>

                    @include('region.content.flight.list', [
                        'items' => $flights
                    ])

                    <div class="r-block__footer">

                        @include('component.link', [
                            'modifiers' => 'm-icon',
                            'title' => trans('frontpage.index.all.offers'),
                            'route' => route('content.index', ['flight']),
                            'icon' => 'icon-arrow-right'
                        ])
                    </div>
                </div>
            @endif

            @if (isset($comments) && count($comments))
                <div class="r-block">
                    <div class="r-block__header">
                        <div class="r-block__header-title">
                            @include('component.title', [
                                'title' => trans('content.comments.title'),
                                'modifiers' => 'm-green'
                            ])
                        </div>
                    </div>

                    <div class="r-block__body">
                        @include('component.comment.index', ['comments' => $comments])
                    </div>
                </div>
            @endif

            @if (\Auth::check())
                <div class="r-block">
                    <div class="r-block__inner">
                        <div class="r-block__header">
                            <div class="r-block__header-title">
                                @include('component.title', [
                                    'title' => trans('content.action.add.comment'),
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

        <div class="r-flights__sidebar">
            <div class="r-block m-small">

                @if ($destination && $parent_destination)

                    @include('component.destination', [
                        'modifiers' => 'm-green',
                        'title' => $destination ? $destination->name : null,
                        'title_route' => $destination ? route('destination.show', $destination) : null,
                        'subtitle' => $parent_destination ? $parent_destination->name : null,
                        'subtitle_route' => $parent_destination ? route('destination.show', $parent_destination) : null,
                    ])

                @endif

                @if (count($sidebar_flights))
                    @foreach ($sidebar_flights as $sidebar_flight)

                        @include('component.card', [
                            'modifiers' => 'm-green',
                            'route' => route('content.show', [$sidebar_flight->type, $sidebar_flight]),
                            'title' => $sidebar_flight->title.' '.$sidebar_flight->price.config('site.currency.symbol'),
                            'image' => $sidebar_flight->imagePreset()
                        ])

                    @endforeach
                @endif

                @if (isset($forums) && count($forums))
                    <div class="r-block__inner">
                        <div class="r-block__header">
                            <div class="r-block__header-title m-flex">
                                @include('component.title', [
                                    'modifiers' => 'm-green',
                                    'title' => trans('destination.show.forum.title')
                                ])
                            </div>
                        </div>

                        <div class="r-block__body">
                            @include('region.content.forum.list', [
                                'modifiers' => [
                                    'main' => 'm-compact',
                                    'badge' => 'm-inverted m-green',
                                ],
                                'items' => $forums
                            ])
                        </div>
                    </div>
                @endif
            </div>

            @if (isset($sidebar_destinations) && count($sidebar_destinations))
                <div class="r-block m-small">
                    @foreach ($sidebar_destinations as $key => $sidebar_destination)
                        @include('component.destination', [
                            'modifiers' => ['m-yellow', 'm-blue', 'm-red', 'm-purple'][($key>3?rand(0,3):$key)],
                            'title' => $sidebar_destination->name,
                            'title_route' => route('destination.show', $sidebar_destination),
                            'subtitle' =>
                                $sidebar_destination->parent_destination ? $sidebar_destination->parent_destination->name : null,
                            'subtitle_route' =>
                                $sidebar_destination->parent_destination ? route('destination.show', $sidebar_destination->parent_destination) : null
                        ])
                    @endforeach
                </div>
            @endif

            @include('component.promo', ['promo' => 'sidebar_small m-small-margin'])

            @if (isset($about) && count($about))
                <div class="r-block m-small">
                    <div class="r-block__inner">
                        @include('component.about', [
                            'title' => trans('content.action.more.about.text'),
                            'text' => trans('content.flight.index.about.text'),
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

            @include('component.promo', ['promo' => 'sidebar_small m-small-margin'])

        </div>
    </div>

    @if (isset($flights2) && count($flights2))
        <div class="r-flights__offers">
            <div class="r-flights__offers-wrap">
                @include('region.content.flight.card', [
                    'items' => $flights2
                ])
            </div>
        </div>
    @endif

    @if (isset($travel_mates) && count($travel_mates))
        <div class="r-flights__travelmates">
            <div class="r-flights__travelmates-wrap">
                <div class="r-flights__travelmates-title">
                    @include('component.title', [
                        'title' => trans('frontpage.index.travelmate.title'),
                        'modifiers' => 'm-green'
                    ])
                </div>

                @include('region.content.travelmate.list', [
                    'items' => $travel_mates
                ])
            </div>
        </div>
    @endif

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
