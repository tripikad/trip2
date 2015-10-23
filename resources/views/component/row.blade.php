{{--

description: Row is meant for listings and content headers

code: |

    @include('component.row', [
        'options' => $options,
        'icon' => 'icon-offer',
        'image' => \App\Image::getRandom(),
        'image_link' => '',
        'profile' => [
            'modifiers' => '',
            'route' => '',
        ],
        'preheading' => 'Preheading',
        'heading' => '',
        'heading_link' => '',
        'postheading' => 'Postheading',
        'actions' => view('component.actions', [
            'actions' => [
                ['route' => '', 'title' => 'This is first action'],
                ['route' => '', 'title' => 'This is second action'],
            ]
        ]),
        'description' => '',
        'extra' => 'Extra',
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

<article class="c-row {{ $item['options'] or '' }}">

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
            'route' => $item['profile']['heading_link'],
            'image' => $item['image']
        ])

    </div>

    @endif

    @if (isset($item['heading']))

    <h3 class="c-row__title">

        @if (isset($item['preheading'])) <span>{!! $item['preheading'] !!}</span> @endif

        <a href="{{ $item['heading_link'] }}" class="c-row__title-link">{{ $item['heading'] }}</a>

        @if (isset( $item['postheading'] )) <span>{!! $item['postheading'] !!}</span> @endif

    </h3>

    @endif

    @if (isset($item['description']))

    <p class="c-row__text">{{ $item['description'] }}</p>

    @endif

    @if (isset($item['extra']))

    <p class="c-row__text">{{ $item['extra'] }}</p>

    @endif

    @if (isset($item['actions']))

    <div class="c-row__actions">{!! $item['actions'] !!}</div>

    @endif

    @if (isset($item['body']))

    <div class="c-row__body">{!! $item['body'] !!}</div>

    @endif

</article>
