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

@if (isset($title))

<div class="c-forum-post m-main">

@else

<div class="c-forum-post">

@endif

    @if (isset($title))

    <h1 class="c-forum-post__title">{{ $title }}</h1>

    @endif

    <div class="c-forum-post__content">

        @if (isset($profile))

            <div class="c-forum-post__profile">

                @include('component.profile', [
                    'modifiers' => $profile['modifiers'],
                    'image' => $profile['image'],
                    'status' => '1',
                    'title' => ''
                ])

            </div>

        @endif

        <div class="c-forum-post__meta">

            @if (isset($profile))

            <div class="c-forum-post__name">

                @include('component.link', [
                    'modifiers' => 'm-small',
                    'title' => $profile['title'],
                    'route' => $profile['route']
                ])

            </div>

            @endif

            <div class="c-forum-post__date">
                {{ $date }}
                @if(isset($date_edit))
                    <span>(Edited: {{ $date_edit }})</span>
                @endif
            </div>

        </div>

        <div class="c-forum-post__body">

            <div class="c-body">

            {!! $text !!}

            </div>

        </div>

        @if(isset($thumbs) || isset($tags))

        <div class="c-forum-post__footer m-flex">

            @if(isset($tags))

            @include('component.tags', [
                'modifiers' => 'm-small',
                'items' => $tags
            ])

            @endif

            @if(isset($thumbs))

            <div class="c-forum-post__thumbs">

                {!! $thumbs !!}

            </div>

            @endif

        </div>

        @endif

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

</div>