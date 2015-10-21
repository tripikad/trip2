{{--

description: Footer Social list

code: |

    @include('component.footer.social', [
        'menu' => 'footer-social',
        'items' => [
            'first' => [
                'route' => '',
                'title' => '',
                'icon' => 'icon-facebook'
            ],
            'second' => [
                'route' => '',
                'title' => '',
                'icon' => 'icon-twitter'
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