@extends('layouts.main')

@section('title')

    {{ $user->name }}

@stop

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('content')

@if (\Auth::check() && \Auth::user()->hasRoleOrOwner('admin', $user->id) || \Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))

<div class="r-user m-green m-logged-in">

@else

<div class="r-user m-green">

@endif

    <div class="r-user__header">

        <div class="r-user__masthead">

            @include('component.masthead', [
                'modifiers' => 'm-alternative m-profile',
                'image' => \App\Image::getRandom()
            ])

        </div>

        <div class="r-user__info">

            <div class="r-user__map">

                @include('component.map')

            </div>

            <div class="r-user__info-wrap">

                <div class="r-user__info-image">

                    @include('component.profile', [
                        'image' => $user->imagePreset('small_square'),
                        'modifiers' => 'm-full m-green',
                    ])

                    @if (isset($latest_announcement) && count($latest_announcement))

                        <div class="r-user__info-travel-mate">

                            @include('component.tooltip', [
                                'modifiers' => 'm-green m-bottom m-one-line',
                                'text' => $latest_announcement->title,
                                'link' => view('component.link', [
                                    'title' => trans('site.link.read.more'),
                                    'route' => route('content.show', [
                                        $latest_announcement->type,
                                        $latest_announcement
                                    ]),
                                    'modifiers' => 'm-small'
                                ])
                             ])

                        </div>

                    @endif

                </div>

                <div class="r-user__info-actions">

                    <ul class="c-button-group">

                        <li class="c-button-group__item">

                            @if (\Auth::user())

                                @if(\Auth::user()->id !== $user->id)

                                    @include('component.button',[
                                        'modifiers' => 'm-secondary m-small',
                                        'title' => trans('user.show.message.create'),
                                        'route' => route('message.index.with', [
                                            \Auth::user(),
                                            $user,
                                            '#message'
                                        ])
                                    ])

                                @else

                                    @include('component.button',[
                                        'modifiers' => 'm-secondary m-small',
                                        'title' => trans('menu.user.message'),
                                        'route' => route('message.index', [$user])
                                    ])

                                @endif

                            @else

                                @include('component.button',[
                                    'modifiers' => 'm-secondary m-small m-disabled',
                                    'title' => trans('user.show.message.create')
                                ])

                            @endif

                        </li>

                        @if (\Auth::user() && \Auth::user()->id == $user->id)

                            <li class="c-button-group__item">

                                @include('component.button',[
                                    'modifiers' => 'm-border m-small',
                                    'title' => trans('menu.user.follow'),
                                    'route' => route('follow.index', [$user])
                                ])

                            </li>

                        @endif


                        @if (isset($user->contact_facebook) && $user->contact_facebook != '')

                            <li class="c-button-group__item">

                                @include('component.button',[
                                    'modifiers' => (
                                        \Auth::check() ? 'm-icon m-small m-round' : 'm-icon m-small m-round m-disabled'
                                    ),
                                    'icon' => view('component.icon',['icon' => 'icon-facebook']),
                                    'route' => (\Auth::check()
                                        ?
                                            $user->contact_facebook
                                        :
                                            false
                                    ),
                                    'target' => '_blank'
                                ])

                            </li>

                        @endif

                        @if (isset($user->contact_twitter) && $user->contact_twitter != '')

                            <li class="c-button-group__item">

                                @include('component.button',[
                                    'modifiers' => (
                                        \Auth::check() ? 'm-icon m-small m-round' : 'm-icon m-small m-round m-disabled'
                                    ),
                                    'icon' => view('component.icon', ['icon' => 'icon-twitter']),
                                    'route' => (\Auth::check()
                                        ?
                                            $user->contact_twitter
                                        :
                                            false
                                    ),
                                    'target' => '_blank'
                                ])

                            </li>

                        @endif

                        @if (isset($user->contact_instagram) && $user->contact_instagram != '')

                            <li class="c-button-group__item">

                                @include('component.button',[
                                    'modifiers' => (
                                        \Auth::check() ? 'm-icon m-small m-round' : 'm-icon m-small m-round m-disabled'
                                    ),
                                    'icon' => view('component.icon',['icon' => 'icon-instagram']),
                                    'route' => (\Auth::check()
                                        ?
                                            $user->contact_instagram
                                        :
                                            false
                                    ),
                                    'target' => '_blank'
                                ])

                            </li>

                        @endif

                        @if (isset($user->contact_homepage) && $user->contact_homepage != '')

                            <li class="c-button-group__item">

                                @include('component.button',[
                                    'modifiers' => (
                                        \Auth::check() ? 'm-icon m-small m-round' : 'm-icon m-small m-round m-disabled'
                                    ),
                                    'icon' => view('component.icon',['icon' => 'icon-plus']),
                                    'route' => (\Auth::check()
                                        ?
                                            $user->contact_homepage
                                        :
                                            false
                                    ),
                                    'target' => '_blank'
                                ])

                            </li>

                        @endif

                    </ul>

                </div>

                <div class="r-user__info-heading">

                    <div class="r-user__info-title">

                        @if(strlen($user->name) >= 30)

                            <h1 class="c-user-title m-long">{{ $user->name }}</h1>

                        @elseif(strlen($user->name) < 30 && strlen($user->name) >= 15)

                            <h1 class="c-user-title">{{ $user->name }}</h1>

                        @else

                            <h1 class="c-user-title m-short">{{ $user->name }}</h1>

                        @endif

                    </div>

                    @if (isset($user_status) && count($user_status))

                        <div class="r-user__info-status">

                            <div class="r-user__info-status-icon">

                                @include ('component.icon', [
                                    'icon' => $user_status->icon
                                ])

                            </div>

                            <div class="r-user__info-status-text">

                                @include ('component.badge', [
                                    'modifiers' => 'm-green m-dark m-inverted',
                                    'title' => $user_status->title
                                ])

                            </div>

                        </div>

                    @endif

                </div>

                @if (count($user->destinationWantsToGo()))

                    <div class="r-user__info-description">

                        @include('component.user.description',[
                            'text' =>
                                trans('user.show.wantstogo.title')
                                .
                                view('component.user.destination', [
                                    'modifiers' => 'm-white',
                                    'destinations' => $user->destinationWantsToGo(),
                                    'take' => 10
                                ])
                        ])

                    </div>

                @endif

                @if (\Auth::check() && (\Auth::user()->hasRoleOrOwner('admin', $user->id) || \Auth::user()->hasRoleOrOwner('superuser', $user->id)))

                    <div class="r-user__info-admin">

                        @include('component.button.group',[
                            'items' => [
                                [
                                    'modifiers' => '',
                                    'button' => view('component.button',[
                                        'modifiers' => 'm-secondary m-small',
                                        'title' => trans('menu.user.edit.profile'),
                                        'route' => route('user.edit', [$user]),
                                    ])
                                ],
                                [
                                    'modifiers' => '',
                                    'button' => view('component.button',[
                                        'modifiers' => 'm-small m-border',
                                        'title' => trans('menu.user.travelmate'),
                                        'route' => route('content.create', ['type' => 'travelmate']),
                                    ])
                                ],
                                [
                                    'modifiers' => 'm-hide',
                                    'button' => view('component.button',[
                                        'modifiers' => 'm-secondary m-small',
                                        'title' => trans('menu.user.activity'),
                                        'route' => route('user.show', [$user])
                                    ])
                                ],
                                [
                                    'modifiers' => 'm-right',
                                    'button' => view('component.button',[
                                        'modifiers' => 'm-secondary m-small',
                                        'title' => trans('menu.user.add.places'),
                                        'route' => '#'
                                    ]),
                                ]
                            ]
                        ])

                     </div>

                @endif

                <div class="r-user__info-extra">

                    @include('component.user.extra', [
                        'items' => [
                            [
                                'icon' => 'icon-comment',
                                'title' =>
                                    (isset($content_count) ? intval($content_count) : 0)
                                    .' / '.
                                    (isset($comment_count) ? intval($comment_count) : 0),
                                'text' =>
                                    trans('user.show.count.content.title')
                                    .' / '.
                                    trans('user.show.count.comment.title'),
                                'route' => ''
                            ],
                            [
                                'icon' => 'icon-pin',
                                'title' =>
                                    $user->destinationHaveBeen()->count()
                                    .' ('.
                                    round(($user->destinationHaveBeen()->count() * 100) / $destinations_count, 2)
                                    .'%)',
                                'text' => trans('user.show.count.visited.destinations'),
                                'route' => ''
                            ],
                        ]
                    ])

                </div>

             </div>

        </div>

    </div>

    @if (isset($photos) && count($photos) > 0)

        <div class="r-user__gallery">

            <div class="r-user__gallery-wrap">

            @include('component.gallery', [
                'items' => $photos->transform(function($photo) {
                    return [
                        'image' => $photo->imagePreset(),
                        'route' => route('content.show', [$photo->type, $photo]),
                        'alt' => $photo->title
                    ];
                }),
                'more_count' => intval($count_photos),
                'more_route' => route('content.show', ['photo'])
            ])

            </div>

        </div>

    @endif

    <div class="r-user__additional">

        <div class="r-user__additional-wrap">

            <div class="r-user__additional-content">

                @if (isset($forum_posts) && count($forum_posts) > 0)

                    <div class="r-user__additional-header">

                        <div class="r-user__additional-title">

                            @include('component.title', [
                                'modifiers' => 'm-green',
                                'title' => trans('site.content.latest.posts')
                            ])

                        </div>

                        <div class="r-user__additional-action">

                            @include('component.link', [
                                'modifiers' => 'm-small',
                                'title' => trans('menu.forum.forum'),
                                'route' => route('content.show', ['forum'])
                            ])

                        </div>

                    </div>

                    @include('component.content.forum.list', [
                        'modifiers' => 'm-compact',
                        'items' => $forum_posts->transform(function($forum_post) use($user) {
                            return [
                                'topic' => $forum_post->title,
                                'route' => route('content.show', [$forum_post->type, $forum_post]),
                                'profile' => [
                                    'modifiers' => 'm-mini',
                                    'image' => $forum_post->imagePreset()
                                ],
                                'badge' => [
                                    'modifiers' => 'm-mini',
                                    'count' => 999
                                ],
                                'children' => [
                                    [
                                        'profile' => [
                                            'image' => $user->imagePreset(),
                                            'title' => $user->title,
                                            'route' => route('user.show', [$user])
                                        ],
                                        'date' => view('component.date.long', [
                                            'date' => $forum_post->created_at
                                        ]),
                                        'text' => $forum_post->body,
                                        'more' => [
                                            'title' => 'Vaata kogu teemat',
                                            'route' => route('content.show', [$forum_post->type, $forum_post])
                                        ]
                                    ]
                                ]
                            ];
                        })
                    ])

                @endif

                <div style="display: none;">

                    @include('component.user.count', [
                        'content_count' => $content_count,
                        'comment_count' => $comment_count
                    ])

                    @if (count($user->destinationHaveBeen()) > 0 || count($user->destinationWantsToGo()) > 0)

                        <div class="utils-border-bottom">

                                @if (count($user->destinationHaveBeen()) > 0)

                                    <h3>{{ trans('user.show.havebeen.title') }}</h3>

                                    @include('component.user.destination', [
                                        'destinations' => $user->destinationHaveBeen()
                                    ])

                                @endif

                        </div>

                        <div class="utils-border-bottom">

                                @if (count($user->destinationWantsToGo()) > 0)

                                    <h3>{{ trans('user.show.wantstogo.title') }}</h3>

                                    @include('component.user.destination', [
                                        'destinations' => $user->destinationWantsToGo()
                                    ])

                                @endif

                        </div>

                    @endif


                    @include('component.user.activity', [
                        'items' => $items
                    ])
                </div>

            </div>

            @if (isset($blogs) && count($blogs) > 0)

                <div class="r-user__additional-sidebar">

                    <div class="r-user__additional-block">

                        <div class="r-user__additional-header">

                            <div class="r-user__additional-title">

                                @include('component.title', [
                                    'modifiers' => 'm-green',
                                    'title' => trans('frontpage.index.travelletter.title')
                                ])

                            </div>

                            <div class="r-user__additional-action">

                                @include('component.link', [
                                    'modifiers' => 'm-small',
                                    'title' => trans('site.link.read.more'),
                                    'route' => route('content.show', ['blog'])
                                ])

                            </div>

                        </div>

                        @foreach ($blogs as $blog)

                            @include('component.blog', [
                                'title' => $blog->title,
                                'route' => route('content.show', [$blog->type, $blog]),
                                'image' => $blog->imagePreset(),
                            ])

                        @endforeach

                    </div>

                    <div class="r-user__additional-block">

                        @include('component.promo', [
                            'route' => '#',
                            'image' => \App\Image::getRandom()
                        ])

                    </div>

                    <div class="r-user__additional-block">

                        @include('component.promo', [
                            'route' => '#',
                            'image' => \App\Image::getRandom()
                        ])

                    </div>

                </div>

            @endif

        </div>

    </div>

    @if (isset($flights) && count($flights) > 0)

        <div class="r-user__offers">

            <div class="r-user__offers-wrap">

                <div class="c-columns m-{{ count($flights) }}-cols">

                    @foreach($flights as $flight)

                        <div class="c-columns__item">

                            @include('component.card', [
                                'route' => route('content.show', [$flight->type, $flight]),
                                'title' => $flight->title,
                                'image' => $flight->imagePreset()
                            ])

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    @endif

    <div class="r-user__footer-promo">

        <div class="r-user__footer-promo-wrap">

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
