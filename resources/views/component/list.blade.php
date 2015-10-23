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

--}}

<ul class="c-list {{ $modifiers or '' }}">

    @foreach ($items as $item)

    <li class="c-list__item {{ $item['modifiers'] or '' }}">

        <h3 class="c-list__item-title">

            <a href="{{ $item['route'] }}" class="c-list__item-title-link">{{ $item['title'] }}</a>

        </h3>

        @if (isset($item['text']))

        <p class="c-list__item-text">

            @if (isset($item['text']))

            {{ $item['text'] }}

            @endif

        </p>

        @endif

    </li>

    @endforeach

</ul>