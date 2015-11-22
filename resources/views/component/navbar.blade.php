<nav class="c-nav js-nav {{ $modifiers or '' }}">

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
</nav>
