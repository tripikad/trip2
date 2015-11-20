<nav class="c-nav {{ $modifiers or '' }}">

    <a href="#" class="c-nav__trigger">
        <span></span>
        <span></span>
        <span></span>
    </a>

    <ul class="c-nav-list">

        @include('component.nav.list', [
            'menu' => 'header',
            'items' => config('menu.header')
        ])

        @if(!auth()->user())

            @include('component.nav.list', [
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

    @if(auth()->user() && ! auth()->user()->hasRole('admin'))

        @include('component.nav.user', [
            'modifiers' => 'm-purple',
            'profile' => [
                'image' => auth()->user()->imagePreset(),
                'title' => auth()->user()->name,
                'route' => route('user.show', [auth()->user()]),
                'badge' => auth()->user()->unreadMessagesCount()
            ],
            'children' => [
                [
                    'title' => trans('menu.user.profile'),
                    'route' => route('user.show', [auth()->user()]),
                ],
                [
                    'title' => trans('menu.user.message'),
                    'route' => route('message.index', [auth()->user()]),
                    'badge' => auth()->user()->unreadMessagesCount()
                ],
                [
                    'title' => trans('menu.user.edit.profile'),
                    'route' => route('user.edit', [auth()->user()]),
                ],
                [
                    'title' => trans('menu.auth.logout'),
                    'route' => route('login.logout'),
                ]
            ]
        ])

    @elseif(auth()->user() && auth()->user()->hasRole('admin'))

        @include('component.nav.user', [
            'modifiers' => 'm-purple',
            'profile' => [
                'image' => auth()->user()->imagePreset(),
                'title' => auth()->user()->name,
                'route' => route('user.show', [auth()->user()]),
                'badge' => auth()->user()->unreadMessagesCount()
            ],
            'children' => [
                [
                    'title' => trans('menu.user.profile'),
                    'route' => route('user.show', [auth()->user()]),
                ],
                [
                    'title' => trans('menu.user.message'),
                    'route' => route('message.index', [auth()->user()]),
                    'badge' => auth()->user()->unreadMessagesCount()
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
                ]
            ]
        ])

    @endif

</nav>
