{{--

title: Nav

code: |

    @include('component.nav', [
        'modifiers' => $modifiers,
        'menu' => 'styleguide',
        'items' => [
            'first' => [
                'title' => 'First',
                'route' => ''
            ],
            'second' => [
                'title' => 'Second',
                'route' => ''
            ],
            'third' => [
                'title' => 'Third',
                'route' => ''
            ]
        ]
    ])

modifiers:

- m-red
- m-blue
- m-green
- m-orange
- m-yellow
- m-purple

--}}

<ul class="c-nav {{ $modifiers or '' }}">

    @foreach ($items as $key => $item)

        <li class="c-nav__list-item @if (isset($item['children'])) m-has-children @endif {{ Ekko::isActiveURL($item['route']) }}">
            <a href="{{ $item['route'] }}" class="c-nav__list-item-link" @if(isset($item['external'])) target="_blank" @endif>

                <span class="c-nav__list-item-link-text">{{ isset($item['title']) ? (trans($item['title']) ? trans($item['title']) : $item['title']) : trans("menu.$menu.$key") }}</span>

                @if (isset($item['profile']))

                    <div class="c-nav__list-item-image">

                        @include('component.profile', [
                            'modifiers' => 'm-mini',
                            'image' => $item['profile']['image'],
                            'badge' => [
                                'modifiers' => 'm-purple m-inverted',
                                'count' => '7'
                            ]
                        ])

                    </div>

                @endif
            </a>

            @if (isset($item['children']))

                <ul class="c-nav__sub-list">

                    @foreach ($item['children'] as $child)

                        <li class="c-nav__sub-list-item">
                            <a href="{{ $child['route'] }}" class="c-nav__sub-list-item-link">
                                {{ $child['title'] }}
                                @if (isset($child['badge']))

                                    <span>
                                        @include('component.badge', [
                                            'modifiers' => $child['badge']['modifiers'],
                                            'count' => $child['badge']['count'],
                                        ])
                                    </span>

                                @endif
                            </a>
                        </li>

                    @endforeach

                </ul>

            @endif
        </li>

    @endforeach

</ul>
