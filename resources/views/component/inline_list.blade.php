{{--

title: Inline list

description: It accepts <code>route</code> parameter.

code: |

    @include('component.inline_list', [
        'modifiers' => '',
        'items' => [
            [
                'title' => 'Item 1',
                'route' => ''
            ],
        ]
    ])

--}}

<ul class="c-inline-list {{ $modifiers or '' }}">
    @foreach ($items as $item)
        @if($item['title'])
            <li class="c-inline-list__item">
                @if(isset($item['route']))
                    <a href="{{ $item['route'] }}" class="c-inline-list__item-link">{!! $item['title'] !!}</a>
                @else
                    {!! $item['title'] !!}
                @endif
            </li>
        @endif
    @endforeach
</ul>
