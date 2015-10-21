{{--

description: Footer social list

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


<ul class="c-footer__social">

    @foreach ($items as $key => $item)

    <li class="c-footer__social-item">

        @include('component.icon', [
            'icon' => $item['icon']
        ])

        <a href="{{ $item['route'] }}" class="c-footer__social-item-link">
            {{ isset($item['title']) ? $item['title'] : trans("menu.$menu.$key") }}
        </a>
    </li>

    @endforeach

</ul>