<?php
/*
title: Tags

code: |

    #include('component.tags', [
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
- m-gray

*/
?>

<ul class="c-tags {{ $modifiers or '' }}">

    @foreach ($items as $index => $item)

    <li class="c-tags__item {{ $item['modifiers'] or 'm-yellow' }}">
        @if(isset($item['route']))
        <a href="{{ $item['route'] }}" class="c-tags__item-link">
        @else
        <span class="c-tags__item-wrap">
        @endif
        {{ $item['title'] }}
        @if(isset($item['route']))
        </a>
        @else
        </span>
        @endif
    </li>

        @if (($index + 1) % (isset($limit) ? $limit : 7) == 0)

            </ul>
            <ul class="c-tags {{ $modifiers or '' }}">

        @endif

    @endforeach

</ul>