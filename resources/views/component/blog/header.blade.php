<div class="c-blog-header {{ $modifiers or '' }}">

    @if (isset($logo))

    <div class="c-blog-header__logo">

        <a href="/" class="c-blog-header__logo-link">

            @include('component.svg.standalone', [
                'name' => 'tripee_logo_blogid'
            ])
        </a>
    </div>

    @endif

    @if(\Auth::user() && ! \Auth::user()->hasRole('admin'))

    <div class="c-blog-header__user">

        @if(isset($modifiers) && $modifiers == 'm-alternative')

            @include('component.navbar.user', [
                'modifiers' => 'm-green m-blog',
                'profile' => [
                    'image' => \Auth::user()->imagePreset(),
                    'title' => \Auth::user()->name,
                    'route' => route('user.show', [\Auth::user()]),
                    'badge' => \Auth::user()->unreadMessagesCount(),
                    'letter' => [
                        'modifiers' => 'm-green m-tiny',
                        'text' => 'W'
                    ]
                ],
                'children' => [
                    [
                        'title' => trans('menu.user.profile'),
                        'route' => route('user.show', [\Auth::user()]),
                    ],
                    [
                        'title' => trans('menu.user.message'),
                        'route' => route('message.index', [\Auth::user()]),
                        'badge' => \Auth::user()->unreadMessagesCount()
                    ],
                    [
                        'title' => trans('menu.user.edit.profile'),
                        'route' => route('user.edit', [\Auth::user()]),
                    ],
                    [
                        'title' => trans('menu.auth.logout'),
                        'route' => route('login.logout'),
                    ]
                ]
            ])

        @else

            @include('component.navbar.user', [
                'modifiers' => 'm-green m-alternative',
                'profile' => [
                    'image' => \Auth::user()->imagePreset(),
                    'title' => \Auth::user()->name,
                    'route' => route('user.show', [\Auth::user()]),
                    'badge' => \Auth::user()->unreadMessagesCount(),
                    'letter' => [
                        'modifiers' => 'm-green m-tiny',
                        'text' => 'W'
                    ]
                ],
                'children' => [
                    [
                        'title' => trans('menu.user.profile'),
                        'route' => route('user.show', [\Auth::user()]),
                    ],
                    [
                        'title' => trans('menu.user.message'),
                        'route' => route('message.index', [\Auth::user()]),
                        'badge' => \Auth::user()->unreadMessagesCount()
                    ],
                    [
                        'title' => trans('menu.user.edit.profile'),
                        'route' => route('user.edit', [\Auth::user()]),
                    ],
                    [
                        'title' => trans('menu.auth.logout'),
                        'route' => route('login.logout'),
                    ]
                ]
            ])

        @endif

    </div>

    @elseif(\Auth::user() && \Auth::user()->hasRole('admin'))

    <div class="c-blog-header__user">

        @if(isset($modifiers) && $modifiers == 'm-alternative')

            @include('component.navbar.user', [
                'modifiers' => 'm-green m-blog',
                'profile' => [
                    'image' => \Auth::user()->imagePreset(),
                    'title' => \Auth::user()->name,
                    'route' => route('user.show', [\Auth::user()]),
                    'badge' => \Auth::user()->unreadMessagesCount(),
                    'letter' => [
                        'modifiers' => 'm-green m-tiny',
                        'text' => 'W'
                    ]
                ],
                'children' => [
                    [
                        'title' => trans('menu.user.profile'),
                        'route' => route('user.show', [\Auth::user()]),
                    ],
                    [
                        'title' => trans('menu.user.message'),
                        'route' => route('message.index', [\Auth::user()]),
                        'badge' => \Auth::user()->unreadMessagesCount()
                    ],
                    [
                        'title' => trans('menu.user.edit.profile'),
                        'route' => route('user.edit', [\Auth::user()]),
                    ],
                    [
                        'title' => trans('menu.auth.admin'),
                        'route' => route('content.index', ['internal'])
                    ],
                    [
                        'title' => trans('menu.auth.logout'),
                        'route' => route('login.logout'),
                    ]
                ]
            ])

        @else

            @include('component.navbar.user', [
                'modifiers' => 'm-green m-alternative',
                'profile' => [
                    'image' => \Auth::user()->imagePreset(),
                    'title' => \Auth::user()->name,
                    'route' => route('user.show', [\Auth::user()]),
                    'badge' => \Auth::user()->unreadMessagesCount(),
                    'letter' => [
                        'modifiers' => 'm-green m-tiny',
                        'text' => 'W'
                    ]
                ],
                'children' => [
                    [
                        'title' => trans('menu.user.profile'),
                        'route' => route('user.show', [\Auth::user()]),
                    ],
                    [
                        'title' => trans('menu.user.message'),
                        'route' => route('message.index', [\Auth::user()]),
                        'badge' => \Auth::user()->unreadMessagesCount()
                    ],
                    [
                        'title' => trans('menu.user.edit.profile'),
                        'route' => route('user.edit', [\Auth::user()]),
                    ],
                    [
                        'title' => trans('menu.auth.admin'),
                        'route' => route('content.index', ['internal'])
                    ],
                    [
                        'title' => trans('menu.auth.logout'),
                        'route' => route('login.logout'),
                    ]
                ]
            ])
        @endif
    </div>

    @endif

    <a href="#" class="c-blog-header__nav-trigger js-header__nav-trigger">
        <span></span>
        <span></span>
        <span></span>
    </a>

    <div class="c-blog-header__mobile-nav js-header__nav">

        @if (isset($modifiers) && $modifiers === 'm-alternative')

            @include('component.navbar.mobile',[
                'modifiers' => 'm-green m-blog'
            ])

        @else

            @include('component.navbar.mobile',[
                'modifiers' => 'm-green m-alternative'
            ])

        @endif

        <div class="c-header__mobile-nav-search">

            @include('component.header.search-simple',[
                'modifiers' => 'm-green',
                'placeholder' => 'Otsi'
            ])
        </div>
    </div>

    <div class="c-blog-header__nav">

        @if(isset($modifiers) && $modifiers == 'm-alternative')

            @include('component.blog.navbar',[
                'modifiers' => 'm-green m-blog'
            ])

        @else

            @include('component.blog.navbar',[
                'modifiers' => 'm-green m-alternative'
            ])

        @endif
    </div>

    <div class="c-blog-header__search js-header__search">

        @if(isset($modifiers) && $modifiers == 'm-alternative')

            @include('component.header.search',[
                'modifiers' => 'm-small m-green m-blog',
                'placeholder' => ''
            ])
        @else

            @include('component.header.search',[
                'modifiers' => 'm-small m-green m-alternative',
                'placeholder' => ''
            ])
        @endif
    </div>

    @if (isset($back))

    <a href="{{ $back['route'] }}" class="c-blog-header__back">{{ $back['title'] }}</a>

        @if ($back['title'] === 'trip.ee blogid')

        <div class="c-blog-header__logo-mobile">

            <a href="{{ $back['route'] }}" class="c-blog-header__logo-link">

                @include('component.svg.standalone', [
                    'name' => 'tripee_logo_plain_blog_dark'
                ])
            </a>
        </div>

        @else

        <div class="c-blog-header__logo-mobile m-small">

            <a href="{{ $back['route'] }}" class="c-blog-header__logo-link">

                @include('component.svg.standalone', [
                    'name' => 'tripee_logo_plain_dark'
                ])
            </a>
        </div>

        @endif

    @endif

</div>