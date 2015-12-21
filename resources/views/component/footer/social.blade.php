{{--

description: Footer Social List

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

        <span class="c-footer__social-item-icon">

            @include('component.svg.sprite', [
                'name' => $item['icon']
            ])

        </span>

        <a href="{{ $item['route'] }}" class="c-footer__social-item-link" @if(isset($item['external'])) target="_blank" @endif>
            {{ isset($item['title']) ? $item['title'] : trans("menu.$menu.$key") }}
        </a>
    </li>

    @endforeach

</ul>
