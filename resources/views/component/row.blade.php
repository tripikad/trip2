{{--

description: Row is meant for listings and content headers

code: |

    @include('component.row', [
        'modifiers' => $options,
        'icon' => 'icon-offer',
        'profile' => [
            'modifiers' => '',
            'route' => '',
            'image' => ''
        ],
        'title' => '',
        'text' => '',
        'route' => '',
        'preheading' => 'Preheading',
        'postheading' => 'Postheading',
        'actions' => view('component.actions', [
            'actions' => [
                ['route' => '', 'title' => 'This is first action'],
                ['route' => '', 'title' => 'This is second action'],
            ]
        ]),
        'body' => 'This book is a record of a pleasure trip. If it were a record of a solemn scientific expedition...',
    ])

options:

- m-icon
- m-profile
- m-red
- m-blue
- m-green
- m-orange
- m-yellow
- m-purple

--}}

<article class="c-row {{ $item['modifiers'] or '' }}">

    @if (isset($item['icon']) && !isset($item['profile']))

    <div class="c-row__icon">

        @include('component.icon', [
            'icon' => $item['icon']
        ])

    </div>

    @endif

    @if (isset($item['profile']) && !isset($item['icon']))

    <div class="c-row__profile">

        @include('component.profile', [
            'modifiers' => $item['profile']['modifiers'],
            'route' => $item['profile']['route'],
            'image' => $item['profile']['image']
        ])

    </div>

    @endif

    @if (isset($item['title']))

    <h3 class="c-row__title">

        @if (isset($item['preheading'])) <span>{!! $item['preheading'] !!}</span> @endif

        <a href="{{ $item['route'] }}" class="c-row__title-link">{{ $item['title'] }}</a>

        @if (isset( $item['postheading'] )) <span>{!! $item['postheading'] !!}</span> @endif

    </h3>

    @endif

    @if (isset($item['text']))

    <p class="c-row__text">{{ $item['text'] }}</p>

    @endif

    @if (isset($item['actions']))

    <div class="c-row__actions">{!! $item['actions'] !!}</div>

    @endif

    @if (isset($item['body']))

    <div class="c-row__body">{!! $item['body'] !!}</div>

    @endif

</article>
