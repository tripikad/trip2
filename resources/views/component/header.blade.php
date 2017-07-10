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

    @if (isset($modifiers) && $modifiers === 'm-alternative')

    <a href="#" class="c-header__nav-trigger js-header__nav-trigger">

    @else

    <a href="#" class="c-header__nav-trigger m-dark js-header__nav-trigger">

    @endif
        <span></span>
        <span></span>
        <span></span>
    </a>

    <div class="c-header__mobile-nav js-header__nav">

        @if (isset($modifiers) && $modifiers === 'm-alternative')

            @include('component.navbar.mobile',[
                'modifiers' => 'm-alternative m-green'
            ])

        @else

            @include('component.navbar.mobile',[
                'modifiers' => 'm-green'
            ])

        @endif

        <div class="c-header__mobile-nav-search">

            @include('component.header.search-simple',[
                'modifiers' => 'm-green',
                'placeholder' => 'Otsi'
            ])
        </div>
    </div>

    <div class="c-header__nav">

        @if (isset($modifiers) && $modifiers === 'm-alternative')

            @include('component.navbar',[
                'modifiers' => 'm-alternative m-green'
            ])

        @else

            @include('component.navbar',[
                'modifiers' => 'm-green'
            ])

        @endif
    </div>

    @if(!Request::is('/') && ((!isset($hide)) || (isset($hide) && !in_array('search', $hide))))

    @if (Request::path() != '/' && !Request::is('search*'))
    <div class="c-header__search js-header__search">

        @if (isset($modifiers) && $modifiers === 'm-alternative')

            @include('component.header.search',[
                'modifiers' => 'm-small m-green m-alternative',
                'placeholder' => ''
            ])

        @else

            @include('component.header.search',[
                'modifiers' => 'm-small m-green',
                'placeholder' => ''
            ])

        @endif

    </div>
    @endif

    @endif

</header>
