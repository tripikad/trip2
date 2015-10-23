{{--

title: About

code: |

    @include('component.about', [
        'modifiers' => $modifiers,
        'title' => 'Trip.ee on reisihuviliste kogukond, keda ühendab reisipisik ning huvi kaugete maade ja kultuuride vastu.',
        'link' => [
            'title' => 'Loe lähemalt Trip.ee-st ›',
            'route' => '#',
        ],
        'button' => [
            'title' => 'Liitu Trip.ee-ga',
            'route' => '#',
            'modifiers' => 'm-block'
        ]
    ])

modifiers:

- m-wide

--}}

<div class="c-about {{ $modifiers or '' }}">

    <div class="c-about__content">

        <h2 class="c-about__title">{{ $title }}</h2>

        @if (isset($link))

            @include('component.link', [
                'title' => $link['title'],
                'route' => $link['route']
            ])

         @endif

    </div>

    @if (isset($button))

    <div class="c-about__action">

        @include('component.button', [
            'modifiers' => $button['modifiers'],
            'title' => $button['title'],
            'route' => $button['route']
        ])

    </div>

    @endif

</div>