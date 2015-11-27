{{--

title: Nav list

code: |

    @include('component.nav.list', [
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

<li class="c-nav-list__item {{ Ekko::isActiveURL($item['route']) }}">
    <a href="{{ $item['route'] }}" class="c-nav-list__item-link" @if(isset($item['external'])) target="_blank" @endif>
        <span class="c-nav-list__item-text">{{ isset($item['title']) ? $item['title'] : trans("menu.$menu.$key") }}</span>
    </a>
</li>

@endforeach
