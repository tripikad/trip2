<nav class="c-nav">

    <ul class="c-nav__list">

        @include('component.menu', [
            'menu' => 'header',
            'items' => config('menu.header')
        ])

        @if(auth()->user() && ! auth()->user()->hasRole('admin'))

            @include('component.menu', [
                'menu' => 'auth',
                'items' => [
                    'user' => [
                        'route' => route('user.show', [auth()->user()]),
                        'title' =>  auth()->user()->name
                    ],
                    'logout' => [
                        'route' => route('login.logout'),
                    ],

                ],
            ])

        @elseif(auth()->user() && auth()->user()->hasRole('admin'))

            @include('component.menu', [
                'menu' => 'auth',
                'items' => [
                    'user' => [
                        'route' => route('user.show', [auth()->user()]),
                        'title' =>  auth()->user()->name
                    ],
                    'admin' => [
                        'route' => route('content.index', ['internal'])
                    ],
                    'logout' => [
                        'route' => route('login.logout'),
                    ],

                ],
            ])

        @else

            @include('component.menu', [
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

