{{--

title: Forum list nav

code: |

    @include('component.content.forum.nav', [
        'items' => []
    ])

--}}

<ul class="c-forum-list-nav">

    @if(isset($items))

        @foreach ($items as $item)

            <li class="c-forum-list-nav__item">

                @if (isset($item['type']) && $item['type'] === 'button')

                    @include('component.button', [
                        'modifiers' => $item['modifiers'],
                        'title' => $item['title'],
                        'route' => $item['route']
                    ])

                @else

                    @if(isset($item['icon']))

                        @include('component.link', [
                            'modifiers' => $item['modifiers'],
                            'title' => $item['title'],
                            'route' => $item['route'],
                            'icon' => $item['icon']
                        ])

                    @else

                        @include('component.link', [
                            'modifiers' => $item['modifiers'],
                            'title' => $item['title'],
                            'route' => $item['route']
                        ])

                    @endif

                @endif

            </li>

        @endforeach

    @endif

</ul>
