<header class="c-header {{ $modifiers or '' }}">

    <div class="c-header__logo">

        @if (isset($modifiers) && $modifiers === 'm-alternative')

        <a href="/" class="c-header__logo-link">

            @include('component.logo', [
                'modifiers' => 'm-small'
            ])

        </a>

        @else

        <a href="/" class="c-header__logo-link">

            @include('component.logo', [
                'modifiers' => 'm-small m-dark'
            ])

        </a>

        @endif

    </div>

    @if(\Auth::user() && ! \Auth::user()->hasRole('admin'))

    <div class="c-header__user">

        @include('component.navbar.user', [
            'modifiers' => 'm-green',
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
    </div>

    @elseif(\Auth::user() && \Auth::user()->hasRole('admin'))

    <div class="c-header__user">

        @include('component.navbar.user', [
            'modifiers' => 'm-purple',
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

    </div>

    @endif

    <a href="#" class="c-header__nav-trigger js-header__nav-trigger">
        <span></span>
        <span></span>
        <span></span>
    </a>

    <div class="c-header__nav js-header__nav">

        @if (isset($modifiers) && $modifiers === 'm-alternative')

            @include('component.navbar',[
                'modifiers' => 'm-alternative m-purple'
            ])

        @else

            @include('component.navbar',[
                'modifiers' => 'm-blue'
            ])

        @endif
    </div>

    <a href="#" class="c-header__search-trigger js-header__search-trigger">

        @include('component.svg.sprite', [
            'name' => 'icon-search'
        ])
    </a>

    <div class="c-header__search js-header__search">

        @if (isset($modifiers) && $modifiers === 'm-alternative')

            @include('component.search',[
                'modifiers' => 'm-small m-red m-alternative',
                'placeholder' => 'Search'
            ])

        @else

            @include('component.search',[
                'modifiers' => 'm-small m-red',
                'placeholder' => 'Search'
            ])

        @endif
    </div>

</header>
