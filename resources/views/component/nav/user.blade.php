{{--

title: Nav user

code: |

    @include('component.nav.user', [
        'modifiers' => '',
        'profile' => [
            'image' => '',
            'title' => '',
            'route' => '',
            'badge' => ''
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

<ul class="c-nav-user {{ $modifiers or '' }}">

    <li class="c-nav-user__item">
        <a href="{{ $profile['route'] }}" class="c-nav-user__item-link">
            <span class="c-nav-user__item-text">{{ $profile['title'] }}</span>

            @if (isset($profile))

            <div class="c-nav-user__item-image">

                @include('component.profile', [
                    'modifiers' => 'm-mini',
                    'image' => $profile['image'],
                    'badge' => [
                        'modifiers' => 'm-inverted '. $modifiers,
                        'count' => $profile['badge']
                    ]
                ])
            </div>

            @endif
        </a>

        @if (isset($children))

            <ul class="c-nav-user__sub">

                @foreach($children as $child)

                    <li class="c-nav-user__sub-item">

                        <a href="{{ $child['route'] }}" class="c-nav-user__sub-item-link">
                            <span class="c-nav-user__sub-item-text">{{ $child['title'] }}</span>

                            @if (isset($child['badge']))

                                <span class="c-nav-user__sub-item-badge">

                                @include('component.badge', [
                                    'modifiers' => $modifiers,
                                    'count' => $child['badge']
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