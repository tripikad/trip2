{{--

title: Tags

code: |

    @include('component.tags', [
        'modifiers' => '',
        'items' => [
            [
                'modifiers' => $modifiers,
                'route' => '',
                'title' => 'Tag name'
            ],
        ]
    ])

parent_modifiers:

- m-small

modifiers:

- m-red
- m-blue
- m-green
- m-yellow
- m-orange
- m-purple

--}}

<ul class="c-tags {{ $modifiers or '' }}">

    @foreach ($items as $item)

    <li class="c-tags__item {{ $item['modifiers'] or 'm-yellow' }}"><a href="{{ $item['route'] }}" class="c-tags__item-link">{{ $item['title'] }}</a></li>

    @endforeach

</ul>