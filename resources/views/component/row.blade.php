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

<article class="c-row {{ $options or '' }}">

    @if (isset($icon) && !isset($profile))

    <div class="c-row__icon">

        @include('component.icon', [
            'icon' => $icon
        ])

    </div>

    @endif

    @if (isset($profile) && !isset($icon))

    <div class="c-row__profile">

        @include('component.profile', [
            'modifiers' => $profile['modifiers'],
            'route' => $heading_link,
            'image' => $image
        ])

    </div>

    @endif

    @if (isset($heading))

    <h3 class="c-row__title">

        @if (isset($preheading)) <span>{!! $preheading !!}</span> @endif

        @if (isset($heading_link)) <a href="{{ $heading_link or '' }}" class="c-row__title-link"> @endif

        {{ $heading }}

        @if (isset($heading_link)) </a> @endif

        @if (isset( $postheading )) <span>{!! $postheading !!}</span> @endif

    </h3>

    @endif

    @if (isset($description))

    <p class="c-row__text">{{ $description }}</p>

    @endif

    @if (isset($extra))

    <p class="c-row__text">{{ $extra }}</p>

    @endif

    @if (isset($actions))

    <div class="c-row__actions">{!! $actions !!}</div>

    @endif

    @if (isset($body))

    <div class="c-row__body">{!! $body !!}</div>

    @endif

</article>
