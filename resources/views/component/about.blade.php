{{--

title: About

code: |

    @include('component.about', [
        'modifiers' => $modifiers,
        'title' => 'Trip.ee on reisihuviliste kogukond, keda ühendab reisipisik ning huvi kaugete maade ja kultuuride vastu.',
        'text' => 'Pakkumised võivad aeguda juba paari päevaga. Paremaks orienteerumiseks on vanemad pakkumised eri värvi.',
        'links' => [
            [
                'title' => 'Loe lähemalt Trip.ee-st ›',
                'route' => '#',
            ],
            [
                'title' => 'Mis on veahind ›',
                'route' => '#',
            ]
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

        @if (isset($text))

            <p class="c-about__text">{{ $text }}</p>

        @endif

        @if (isset($links))

            <div class="c-about__links">

                @foreach ($links as $link)

                    @include('component.link', [
                        'modifiers' => 'm-block',
                        'title' => $link['title'],
                        'route' => $link['route']
                    ])

                @endforeach

            </div>

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
