<?php
/*
title: Forum list nav

code: |

    #include('component.content.forum.nav', [
        'items' => []
    ])

*/
?>

<ul class="c-forum-list-nav">

    @if(isset($items))
        @foreach ($items as $item)
            @if (count($item))
                @if (isset($item['type']) && $item['type'] === 'button')
                    <li class="c-forum-list-nav__item m-button {{ Ekko::isActiveURL($item['route']) }}">
                        @include('component.button', [
                            'modifiers' => $item['modifiers'],
                            'title' => (trans($item['title']) ? trans($item['title']) : $item['title']),
                            'route' => $item['route']
                        ])
                    </li>
                @else
                    <li class="c-forum-list-nav__item {{ Ekko::isActiveURL($item['route']) }}">
                        @if(isset($item['icon']))
                            <a href="{{ $item['route'] }}" class="c-forum-list-nav__item-link">{{ (trans($item['title']) ? trans($item['title']) : $item['title']) }}
                                <span class="c-forum-list-nav__item-icon">
                                    @include('component.svg.sprite', [
                                        'name' => $item['icon']
                                    ])
                                </span>
                            </a>
                        @else
                            <a href="{{ $item['route'] }}" class="c-forum-list-nav__item-link">{{ (trans($item['title']) ? trans($item['title']) : $item['title']) }}</a>
                        @endif
                    </li>
                @endif
            @endif
        @endforeach
    @endif
</ul>
