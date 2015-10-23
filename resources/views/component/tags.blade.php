{{--

title: Tags

code: |

    @include('component.tags', [
        'items' => [
            [
                'modifiers' => $options,
                'route' => '',
                'title' => 'Tag name'
            ],
        ]
    ])

options:

- m-red
- m-blue
- m-green
- m-yellow
- m-orange
- m-purple

--}}

<ul class="c-tags">

    @foreach ($items as $item)

    <li class="c-tags__item {{ $item['modifiers'] or 'm-yellow' }}"><a href="{{ $item['route'] }}" class="c-tags__item-link">{{ $item['title'] }}</a></li>

    @endforeach

</ul>