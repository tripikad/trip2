@extends('layouts.main')

@section('title', $user->real_name && $user->real_name_show ? $user->real_name : $user->name)

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('content')

@if (\Auth::check() && \Auth::user()->hasRoleOrOwner('admin', $user->id) || \Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))

<div class="r-user {{ $user->profile_color }} m-logged-in">

@else

<div class="r-user {{ $user->profile_color }}">

@endif

    <div class="r-user__header">
        <div class="r-user__masthead {{ $user->profile_color }}">

            @include('component.masthead', [
                'modifiers' => 'm-alternative m-profile',
                'image' => \App\Image::getHeader()
            ])

        </div>

        <div class="r-user__map">
            <div class="c-user-map">
                <div class="c-user-map__map">
                    @include('component.svg.standalone', [
                        'name' => 'map'
                    ])
                </div>
            </div>
        </div>

        <div class="r-user__info">
            <div class="r-user__info-wrap">
                <div class="r-user__info-image">
                    @include('component.profile', [
                        'image' => $user->imagePreset('small_square'),
                        'modifiers' => 'm-full '.$user->profile_color.' m-status m-user',
                        'letter' => [
                            'modifiers' => $user->profile_color.' m-large',
                            'text' => (strlen($user->name) ? $user->name[0] : '')
                        ],
                        'status' => [
                            'position' => $user->rank,
                            'modifiers' => $user->profile_color,
                            'editor' => $user->role == 'admin'?true:false,
                            'tooltip' => false,
                        ],
                    ])

                    @if (isset($latest_announcement) && count($latest_announcement))
                        <div class="r-user__info-travel-mate">
                            @include('component.tooltip', [
                                'modifiers' => $user->profile_color.' m-bottom m-one-line',
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

                    <div class="r-user__info-level">
                        @include('component.user.status', [
                            'modifiers' => $user->profile_color,
                            'status' => $user->rank,
                            'editor' => $user->role == 'admin'?true:false,
                        ])
                    </div>

                </div>

                <div class="r-user__info-heading">
                    <div class="r-user__info-title">
                        <div class="r-user__info-title-wrap">
                            <h1 class="c-user-title">{{ $user->real_name && $user->real_name_show ? $user->real_name : $user->name }}</h1>
                            @if(\Auth::user() && \Auth::user()->id !== $user->id)
                                @include('component.button',[
                                    'modifiers' => 'm-secondary m-small',
                                    'title' => trans('user.show.message.create'),
                                    'route' => route('message.index.with', [
                                        \Auth::user(),
                                        $user,
                                        '#message'
                                    ])
                                ])
                            @endif
                        </div>

                        <div class="c-user-title__sub">
                            <ul class="c-button-group m-small">
                                @if (isset($user->contact_facebook) && $user->contact_facebook != '')
                                    <li class="c-button-group__item">
                                        @include('component.button',[
                                            'modifiers' => (
                                                \Auth::check() ? 'm-icon m-small m-round m-secondary' : 'm-icon m-small m-round m-disabled'
                                            ),
                                            'icon' => view('component.svg.sprite', ['name' => 'icon-facebook']),
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
                                                \Auth::check() ? 'm-icon m-small m-round m-secondary' : 'm-icon m-small m-round m-disabled'
                                            ),
                                            'icon' => view('component.svg.sprite', ['name' => 'icon-twitter']),
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
                                                \Auth::check() ? 'm-icon m-small m-round m-secondary' : 'm-icon m-small m-round m-disabled'
                                            ),
                                            'icon' => view('component.svg.sprite', ['name' => 'icon-instagram']),
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
                                                \Auth::check() ? 'm-icon m-small m-round m-secondary' : 'm-icon m-small m-round m-disabled'
                                            ),
                                            'icon' => view('component.svg.sprite', ['name' => 'icon-house']),
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
                            <p class="c-user-title__sub-info">{{
                            trans('user.show.joined', [
                                'user' => $user->name,
                                'created_at' => view('component.date.relative', ['date' => $user->created_at])
                            ]) }}</p>
                        </div>
                    </div>

                    {{--

                    @if (isset($user_status) && count($user_status))

                        <div class="r-user__info-status">

                            <div class="r-user__info-status-icon">

                                @include ('component.svg.sprite', [
                                    'name' => $user_status->icon
                                ])

                            </div>

                            <div class="r-user__info-status-text">

                                @include ('component.badge', [
                                    'modifiers' => $user->profile_color.' m-dark m-inverted',
                                    'title' => $user_status->title
                                ])

                            </div>

                        </div>

                    @endif

                    --}}

                </div>
                    <div class="r-user__info-description">
                        <div class="c-body">
                            @if ($user->description)
                                <p>{{ $user->description }}</p>
                            @endif

                            @if (count($user->destinationWantsToGo()))

                                @include('component.user.description',[
                                    'text' =>
                                        trans('user.show.wantstogo.title')
                                        .
                                        view('component.user.destination', [
                                            'modifiers' => 'm-white',
                                            'destinations' => $user->destinationWantsToGo()->sortByDesc('id')->take(10)
                                        ])
                                ])
                            @endif
                        </div>
                    </div>
                <div class="r-user__info-extra">
                    @include('component.user.extra', [
                        'items' => [
                            [
                                'icon' => 'icon-thumb-up',
                                'title' => $user->likes()->count(),
                                'text' => trans('user.show.likes'),
                                'route' => ''
                            ],
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
                                    $user->destinationHaveBeen()->count().' ('.$destinations_percent.'%)',
                                'text' => trans('user.show.count.visited.destinations'),
                                'route' => ''
                            ],
                        ]
                    ])
                </div>
             </div>
        </div>
    </div>

    @if (\Auth::check() && (\Auth::user()->hasRoleOrOwner('admin', $user->id) || \Auth::user()->hasRoleOrOwner('superuser', $user->id)))
    <div class="r-user__admin">
        <div class="r-user__admin-wrap">
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
                            'modifiers' => 'm-secondary m-small',
                            'title' => trans('menu.user.message'),
                            'route' => route('message.index', [$user])
                        ])
                    ],
                    [
                        'modifiers' => '',
                        'button' => view('component.button',[
                            'modifiers' => 'm-border m-small',
                            'title' => trans('menu.user.follow'),
                            'route' => route('follow.index', [$user])
                        ])
                    ],
                    [
                        'modifiers' => '',
                        'button' => view('component.button',[
                            'modifiers' => 'm-small m-border',
                            'title' => trans('menu.user.photo'),
                            'route' => route('content.create', ['type' => 'photo']),
                        ])
                    ],
                    [
                        'modifiers' => 'm-hide',
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
                            'route' => ($user->name != 'Tripi külastaja' ? route('user.show', [$user]) : false)
                        ])
                    ],
                    [
                        'modifiers' => 'm-right',
                        'button' => view('component.button',[
                            'modifiers' => 'm-secondary m-small',
                            'title' => trans('menu.user.add.places'),
                            'route' => route('user.destinations', [$user])
                        ]),
                    ]
                ]
            ])
        </div>
     </div>
    @endif

    @if (isset($photos) && count($photos) > 0)
        <div class="r-user__gallery">
            <div class="r-user__gallery-wrap">
                @include('component.gallery', [
                    'modal' => [
                        'modifiers' => $user->profile_color,
                    ],
                    'items' => $photos->transform(function($photo) {
                        return [
                            'type' => $photo->type,
                            'image' => $photo->imagePreset('small'),
                            'image_large' => $photo->imagePreset('large'),
                            'route' => route($photo->type.'.show', [$photo->slug]),
                            'alt' => $photo->title,
                            'tags' => $photo->destinations->transform(function($destination) {
                                return [
                                    'title' => $destination->name,
                                    'modifiers' => ['m-orange', 'm-red', 'm-yellow', 'm-blue'][rand(0,3)],
                                    'route' => route('destination.showSlug', $destination->slug)
                                ];
                            })
                        ];
                    }),
                    'more_count' => $count_photos,
                    'more_route' => route('content.index', [
                        $photos->first()['type'],
                        'author=' . $user->id
                    ])
                ])
            </div>
        </div>
    @endif

    <div class="r-user__additional">
        <div class="r-user__additional-wrap">
        @if (isset($activities) && count($activities) > 0 || isset($activities) && count($activities) > 0)
            <div class="r-user__additional-content">
                @if (isset($activities) && count($activities) > 0)
                    <div class="r-user__additional-header">
                        <div class="r-user__additional-title">
                            @include('component.title', [
                                'modifiers' => $user->profile_color,
                                'title' => trans('user.activity.index.title')
                            ])
                        </div>
                        <div class="r-user__additional-action">
                            @include('component.link', [
                                'modifiers' => 'm-icon m-right m-small',
                                'title' => trans('menu.forum.forum'),
                                'route' => route('forum.index'),
                                'icon' => 'icon-arrow-right'
                            ])

                        </div>
                    </div>

                    @include('component.user.activity', [
                        'items' => $activities
                    ])

                @endif
            </div>

            <div class="r-user__additional-sidebar">

                @if (isset($blog_posts) && count($blog_posts) > 0)

                <div class="r-user__additional-block">
                    <div class="r-user__additional-header">
                        <div class="r-user__additional-title">
                            @include('component.title', [
                                'modifiers' => $user->profile_color,
                                'title' => trans('frontpage.index.travelletter.title')
                            ])
                        </div>

                        <div class="r-user__additional-action">
                            @include('component.link', [
                                'modifiers' => 'm-icon m-right m-small',
                                'title' => trans('site.link.read.more'),
                                'route' => route('blog.index'),
                                'icon' => 'icon-arrow-right'
                            ])
                        </div>
                    </div>

                    @foreach ($blog_posts as $blog_post)
                        @include('component.blog', [
                            'title' => $blog_post->title,
                            'route' => route($blog_post->type.'.show', [$blog_post->slug]),
                            'image' => $blog_post->imagePreset(),
                        ])
                    @endforeach
                </div>

                @endif

                <div class="r-block m-small m-mobile-hide">
                    @include('component.promo', ['promo' => 'sidebar_large'])
                </div>

                <div class="r-block m-small m-mobile-hide">
                    @include('component.promo', ['promo' => 'sidebar_small'])
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
                                'route' => route($flight->type.'.show', [$flight->slug]),
                                'title' => $flight->title.' '.$flight->price.' '.config('site.currency.symbol'),
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
