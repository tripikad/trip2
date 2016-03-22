{{--

title: List

code: |

    @include('component.list', [
        'modifiers' => $modifiers,
        'items' => [
            [
                'modifiers' => '',
                'title' => 'Item 1',
                'text' => 'Text',
                'route' => ''
            ],
        ]
    ])

modifiers:

- m-dot m-red
- m-dot m-blue
- m-dot m-green
- m-dot m-orange
- m-dot m-yellow
- m-dot m-purple
- m-large
- m-red
- m-blue
- m-green
- m-orange
- m-yellow
- m-purple
- m-dark

--}}

<ul class="c-list {{ $modifiers or '' }}">

    @foreach ($items as $item)

        <li class="c-list__item {{ $item['modifiers'] or '' }}"{{ (isset($item['id']) ? ' id="' . $item['id'] . '"' : '') }}>

            @if (isset($item['icon']) || isset($item['profile']['image']) || isset($item['title']))

                <h3 class="c-list__item-title">

                    @if (isset($item['route']))

                        <a href="{{ $item['route'] }}" class="c-list__item-title-link">

                    @endif

                        @if (isset($item['icon']))

                            <span class="c-list__item-icon">

                                @include('component.svg.sprite',[
                                    'name' => $item['icon']
                                ])

                            </span>

                        @elseif (isset($item['profile']['image']))

                            <span class="c-list__item-image">

                                @include('component.profile', [
                                    'modifiers' => $item['profile']['modifiers'],
                                    'route' => $item['profile']['route'],
                                    'image' => $item['profile']['image'],
                                    'title' => ''
                                ])

                            </span>

                        @endif

                        @if (isset($item['title']))

                            {{ $item['title'] }}

                        @endif

                    @if (isset($item['route']))

                        </a>

                    @endif

                </h3>

            @endif

            @if (isset($item['text']))

                <p class="c-list__item-text">

                    @if (isset($item['text']))

                        {!! $item['text'] !!}

                    @endif

                </p>

            @endif

        </li>

    @endforeach

</ul>
