<nav class="c-navbar js-navbar {{ $modifiers or '' }}">

    <ul class="c-navbar-list">

        @include('component.navbar.list', [
            'menu' => 'header',
            'items' => config('menu.header')
        ])

        @if(! \Auth::user())

            @include('component.navbar.list', [
                'items' => [
                    'first' => [
                        'title' => 'Minu Trip.ee',
                        'route' => route('login.form'),
                        'children' => [
                            'login' => [
                                'title' => 'Logi sisse',
                                'route' => route('login.form')
                            ],
                            'register' => [
                                'title' => 'Registreeri',
                                'route' => route('register.form'),
                            ],
                        ]
                    ],
                ]
            ])

        @endif

    </ul>

    @if(\Auth::user())

    <div class="c-navbar-user">

        @if(\Auth::user() && ! \Auth::user()->hasRole('admin'))

            @include('component.navbar.user-mobile', [
                'modifiers' => 'm-green',
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
        @elseif(\Auth::user() && \Auth::user()->hasRole('admin'))

            @include('component.navbar.user-mobile', [
                'modifiers' => 'm-purple',
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
</nav>
