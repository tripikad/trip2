{{--

title: Footer Navigation List

code: |

    @include('component.footer.nav', [
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

<ul class="c-footer__nav-list">

    @foreach ($items as $key => $item)

    <li class="c-footer__nav-list-item {{ Ekko::isActiveURL($item['route']) }}">
        <a href="{{ $item['route'] }}" class="c-footer__nav-link" @if(isset($item['external'])) target="_blank" @endif>
            {{ isset($item['title']) ? $item['title'] : trans("menu.$menu.$key") }}
        </a>
    </li>

    @endforeach

</ul>
