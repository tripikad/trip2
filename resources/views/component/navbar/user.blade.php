{{--

title: Navbar user

code: |

    @include('component.navbar.user', [
        'modifiers' => '',
        'profile' => [
            'image' => '',
            'title' => '',
            'route' => '',
            'badge' => '',
            'letter' => [
                'modifiers' => 'm-green m-tiny',
                'text' => 'W'
            ]
        ],
        'children' => [
            [
                'title' => '',
                'route' => '',
                'badge' => ''
            ],
            [
                'title' => '',
                'route' => ''
            ]
        ]
    ])

--}}

<ul class="c-navbar-user {{ $modifiers or '' }}">

    <li class="c-navbar-user__item">
        <a href="{{ $profile['route'] }}" class="c-navbar-user__item-link">
            <span class="c-navbar-user__item-text">{{ str_limit($profile['title'], 15) }}</span>

            @if (isset($profile))

            <div class="c-navbar-user__item-image">

                @include('component.profile', [
                    'modifiers' => 'm-mini',
                    'image' => $profile['image'] . '?' . str_random(4),
                    'letter' => $profile['letter'],
                    'title' => null,
                    'badge' => [
                        'modifiers' => 'm-inverted m-red',
                        'count' => $profile['badge'],
                    ]
                ])
            </div>

            @endif
        </a>

        @if (isset($children))

            <ul class="c-navbar-user__sub">

                @foreach($children as $child)

                    <li class="c-navbar-user__sub-item">

                        <a href="{{ $child['route'] }}" class="c-navbar-user__sub-item-link">
                            <span class="c-navbar-user__sub-item-text">{{ $child['title'] }}</span>

                            @if (isset($child['badge']))

                                <span class="c-navbar-user__sub-item-badge">

                                @include('component.badge', [
                                    'modifiers' => $modifiers,
                                    'count' => $child['badge'],
                                ])

                                </span>

                            @endif
                        </a>

                    </li>

                @endforeach

            </ul>

        @endif
    </li>
</ul>