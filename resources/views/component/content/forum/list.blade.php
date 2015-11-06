{{--

title: Forum list

code: |

    @include('component.content.forum.list', [
        'modifiers' => $modifiers,
        'items' => [
            [
                'topic' => 'This book is a record of a pleasure trip. If it were a record of a solemn scientific expedition',
                'route' => '#',
                'profile' => [
                    'modifiers' => 'm-mini',
                    'image' => \App\Image::getRandom()
                ],
                'badge' => [
                    'modifiers' => 'm-inverted',
                    'count' => 9
                ],
                'tags' => [
                    [
                        'title' => 'Inglismaa',
                        'modifiers' => 'm-green',
                        'route' => ''
                    ]
                ]
            ]
        ]
    ])

modifiers:

- m-compact

--}}

<ul class="c-forum-list {{ $modifiers or '' }}">

    @if(isset($items))

        @foreach ($items as $item)

            <li class="c-forum-list__item">

                @if (isset($item['route']))

                    <a href="{{ $item['route'] }}" class="c-forum-list__item-link">

                @else

                    <div class="c-forum-list__item-content">

                @endif

                @if (isset($item['profile']))

                    <div class="c-forum-list__item-profile">

                        @include('component.profile', [
                            'modifiers' => $item['profile']['modifiers'],
                            'image' => $item['profile']['image'],
                            'badge' => $item['badge']
                        ])

                    </div>

                @endif

                <h3 class="c-forum-list__item-topic">{{ $item['topic'] }}</h3>

                @if (isset($item['route']))

                    </a>

                @else

                    </div>

                @endif

                @if (isset($item['tags']))

                    <div class="c-forum-list__item-tags">

                        @include('component.tags', [
                            'modifiers' => 'm-small',
                            'items' => $item['tags']
                        ])

                    </div>

                @endif

                @if(isset($item['children']))

                    <ul class="c-forum-list__sublist">

                    @foreach ($item['children'] as $child)

                        <li class="c-forum-list__sublist-item">

                            @if (isset($child['profile']))

                                <div class="c-forum-list__sublist-item-profile">

                                    @include('component.profile', [
                                        'modifiers' => $child['profile']['modifiers'],
                                        'image' => $child['profile']['image']
                                    ])

                                </div>

                            @endif

                            <div class="c-forum-list__sublist-item-meta">

                                @if (isset($child['profile']))

                                    @include('component.link', [
                                        'modifiers' => '',
                                        'title' => $child['profile']['title'],
                                        'route' => $child['profile']['route']
                                    ])

                                @endif

                                <span>{{ $child['date'] }}</span>

                            </div>

                            <div class="c-forum-list__sublist-item-content">

                                {{ $child['text'] }}

                            </div>

                            <div class="c-forum-list__sublist-item-actions">

                                @include('component.link', [
                                    'title' => 'Vaata kogu teemat',
                                    'route' => ''
                                ])

                            </div>

                        </li>

                    @endforeach

                    </ul>

                @endif

            </li>

        @endforeach

    @endif

</ul>
