{{--

title: Nav

code: |

    @include('component.nav', [
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

--}}

@foreach ($items as $key => $item)

<li class="c-nav__list-item">
    <a href="{{ $item['route'] }}" class="c-nav__list-item-link">
        {{ isset($item['title']) ? $item['title'] : trans("menu.$menu.$key") }}
    </a>
</li>

@endforeach
