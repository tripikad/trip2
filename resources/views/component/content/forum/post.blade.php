{{--

title: Forum post

code: |

    @include('component.content.forum.post', [
        'profile' => [
            'modifiers' => '',
            'image' => '',
            'title' => '',
            'route' => ''
        ],
        'date' => '',
        'text' => '',
        'more' => [
            'modifiers' => '',
            'title' => '',
            'route' => ''
        ]
    ])

--}}

<div class="c-forum-post">

    @if (isset($profile))

        <div class="c-forum-post__profile">

            @include('component.profile', [
                'modifiers' => 'm-mini',
                'image' => $profile['image']
            ])

        </div>

    @endif

    <div class="c-forum-post__meta">

        @if (isset($profile))

            @include('component.link', [
                'modifiers' => 'm-small',
                'title' => $profile['title'],
                'route' => $profile['route']
            ])

        @endif

        <span>{{ $date }}</span>

    </div>

    <div class="c-forum-post__content">

        <div class="c-body">

        {!! $text !!}

        </div>

    </div>

    @if(isset($more))

    <div class="c-forum-post__footer {{ $more['modifiers'] or '' }} ">

        @include('component.link', [
            'modifiers' => 'm-small m-icon m-right',
            'title' => $more['title'],
            'route' => $more['route'],
            'icon' => 'icon-arrow-right'
        ])

    </div>

    @endif

</div>