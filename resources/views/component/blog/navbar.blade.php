<nav class="c-navbar js-navbar {{ $modifiers or '' }}">

    <ul class="c-navbar-list">

        <?php /* Title = 'Alusta blogimist' */ ?>

        @include('component.navbar.list', [
            'items' => [
                [
                    'title' => trans("content.blog.create.title"),
                    'route' => route('blog.create'),
                    'modifiers' => ' m-border'
                ]
            ]
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
</nav>