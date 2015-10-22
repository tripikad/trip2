{{--

description: List component

code: |

    @include('component.list', [
        'modifiers' => $options,
        'items' => [
            [
                'icon' => '',
                'modifiers' => '',
                'title' => '',
                'text' => '',
                'route' => '',
                'profile' => [
                    'route' => '',
                    'image' => ''
                ],
                'preheading' => '',
                'postheading' => '',
                'extra' => ''
            ],
        ]
    ])

--}}

<ul class="c-list {{ $modifiers or '' }}">

    @foreach ($items as $item)

    <li class="c-list__item {{ $item['modifiers'] or '' }}">

        @if (isset($item['icon']))

        <div class="c-list__item-icon">

            @include('component.icon', ['icon' => $item['icon'] ])

        </div>

        @endif

        @if (isset($item['profile']))

        <div class="c-list__item-profile">

            @include('component.profile', [
                'modifiers' => $item['modifiers'],
                'route' => $item['profile']['route'],
                'image' => \App\Image::getRandom()
            ])

        </div>

        @endif

        <h3 class="c-list__item-title">

            @if (isset($item['preheading'])) <span>{!! $item['preheading'] !!}</span> @endif

            <a href="{{ $item['route'] }}" class="c-list__item-title-link">{{ $item['title'] }}</a>

            @if (isset($item['postheading'])) <span>{!! $item['postheading'] !!}</span> @endif

        </h3>

        @if (isset($item['text']) || isset($item['extra']))

        <p class="c-list__item-text">

            @if (isset($item['text']))

            {{ $item['text'] }}

            @endif

            @if (isset($item['extra']))

            <span>{{ $item['extra'] }}</span>

            @endif

        </p>

        @endif

    </li>

    @endforeach

</ul>