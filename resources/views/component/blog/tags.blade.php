{{--

title: Blog tags

code: |

    @include('component.blog.tags', [
        'items' => [
            [
                'route' => '',
                'title' => 'Tag name'
            ],
        ]
    ])

--}}

<ul class="c-blog-tags">

    @foreach ($items as $item)

    <li class="c-blog-tags__item">
        <a href="{{ $item['route'] }}" class="c-blog-tags__item-link">
            {{ $item['title'] }}
        </a>
    </li>

    @endforeach

</ul>