<header class="c-header {{ $modifiers or '' }}">

    <div class="c-header__logo">

        @if (isset($modifiers) && $modifiers === 'm-alternative')

            @include('component.logo', [
                'modifiers' => 'm-small'
            ])

        @else

            @include('component.logo', [
                'modifiers' => 'm-small m-dark'
            ])

        @endif
    </div>

    @if(auth()->user() && ! auth()->user()->hasRole('admin'))

    <div class="c-header__user">

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
    </div>

    @elseif(auth()->user() && auth()->user()->hasRole('admin'))

    <div class="c-header__user">

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
    </div>

    @endif

    <a href="#" class="c-header__nav-trigger">
        <span></span>
        <span></span>
        <span></span>
    </a>

    <div class="c-header__nav">

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

    <a href="#" class="c-header__search-trigger">

        @include('component.icon', [
            'icon' => 'icon-search'
        ])
    </a>

    <div class="c-header__search">

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