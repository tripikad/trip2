<nav class="c-nav {{ $modifiers or '' }}">

    <ul class="c-nav__list">

        @include('component.nav', [
            'menu' => 'header',
            'items' => config('menu.header')
        ])

        @if(auth()->user() && ! auth()->user()->hasRole('admin'))

            @include('component.nav', [
                'menu' => 'auth',
                'items' => [
                    'user' => [
                        'route' => route('user.show', [auth()->user()]),
                        'title' =>  auth()->user()->name,
                        'children' => [
                            [
                                'title' => trans('menu.user.profile'),
                                'route' => route('user.show', [auth()->user()]),
                            ],
                            [
                                'title' => trans('menu.user.message'),
                                'route' => route('message.index', [auth()->user()]),
                                'badge' => [
                                    'modifiers' => 'm-purple',
                                    'count' => auth()->user()->unreadMessagesCount()
                                ]
                            ],
                            [
                                'title' => trans('menu.user.edit.profile'),
                                'route' => route('user.edit', [auth()->user()]),
                            ],
                            [
                                'title' => trans('menu.auth.logout'),
                                'route' => route('login.logout'),
                            ],
                        ]
                    ],
                    'second' => [
                        'title' => '',
                        'route' => route('user.show', [auth()->user()]),
                        'profile' => [
                            'image' => auth()->user()->imagePreset(),
                        ],
                    ]
                ],
            ])

        @elseif(auth()->user() && auth()->user()->hasRole('admin'))

            @include('component.nav', [
                'menu' => 'auth',
                'items' => [
                    'user' => [
                        'route' => route('user.show', [auth()->user()]),
                        'title' =>  auth()->user()->name,
                        'children' => [
                            [
                                'title' => trans('menu.user.profile'),
                                'route' => route('user.show', [auth()->user()]),
                            ],
                            [
                                'title' => trans('menu.user.message'),
                                'route' => route('message.index', [auth()->user()]),
                                'badge' => [
                                    'modifiers' => 'm-blue',
                                    'count' => auth()->user()->unreadMessagesCount()
                                ]
                            ],
                            [
                                'title' => trans('menu.user.edit.profile'),
                                'route' => route('user.edit', [auth()->user()]),
                            ],
                            [
                                'title' => trans('menu.auth.admin'),
                                'route' => route('content.index', ['internal'])
                            ],
                            [
                                'title' => trans('menu.auth.logout'),
                                'route' => route('login.logout'),
                            ],
                        ]
                    ],
                    'second' => [
                        'title' => '',
                        'route' => route('user.show', [auth()->user()]),
                        'profile' => [
                            'image' => auth()->user()->imagePreset(),
                        ],
                    ]
                ],
            ])

        @else

            @include('component.nav', [
                'menu' => 'auth',
                'items' => [
                    'register' => [
                        'route' => route('register.form'),
                    ],
                    'login' => [
                        'route' => route('login.form')
                    ],
                ],
            ])

        @endif

    </ul>

</nav>
