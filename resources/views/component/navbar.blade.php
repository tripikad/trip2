<nav class="c-navbar js-navbar {{ $modifiers or '' }}">

    <ul class="c-navbar-list">

        @include('component.navbar.list', [
            'menu' => 'header',
            'items' => config('menu.header')
        ])

{{--
        @if(! \Auth::user())

            @include('component.navbar.list', [
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
--}}

        @if(! \Auth::user())

            @include('component.navbar.list', [
                'menu' => 'auth',
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
</nav>
