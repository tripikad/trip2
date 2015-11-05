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
                        'profile' => [
                            'image' => \App\Image::getRandom(),
                        ],
                        'children' => [
                            [
                                'title' => trans('menu.user.profile'),
                                'route' => route('user.show', [auth()->user()]),
                            ],
                            [
                                'title' => 'Sõnumid',
                                'route' => route('message.index', [auth()->user()]),
                                'badge' => [
                                    'modifiers' => 'm-blue',
                                    'count' => '2'
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
                                'title' => trans('menu.auth.admin'),
                                'route' => route('content.index', ['internal'])
                            ],
                            [
                                'title' => trans('menu.auth.logout'),
                                'route' => route('login.logout'),
                            ],
                        ]
                    ],
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
