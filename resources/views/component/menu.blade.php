{{--

title: Menu

code: |

    @include('component.menu', [
        'menu' => 'styleguide',
        'items' => [
            'first' => [
                'route' => ''
            ],
            'second' => [
                'route' => ''
            ],
            'third' => [
                'route' => ''
            ]
        ]
    ])

--}}

{{-- <ul class="list-inline text-center {{ $options or '' }}">

    @foreach ($items as $key => $item)

        <li>

            <a href="{{ $item['route'] }}">

                {{ isset($item['title']) ? $item['title'] : trans("menu.$menu.$key") }}

            </a>

        </li>

    @endforeach

</ul> --}}



@foreach ($items as $key => $item)

<li class="c-nav__list-item">
    <a href="{{ $item['route'] }}" class="c-nav__list-item-link">
        {{ isset($item['title']) ? $item['title'] : trans("menu.$menu.$key") }}
    </a>
</li>

@endforeach
