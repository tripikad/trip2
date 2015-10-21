{{--

description: Footer Navigation list

code: |

    @include('component.footernav', [
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

    <li class="c-footer__nav-list-item">
        <a href="{{ $item['route'] }}" class="c-footer__nav-link">
            {{ isset($item['title']) ? $item['title'] : trans("menu.$menu.$key") }}
        </a>
    </li>

    @endforeach

</ul>
