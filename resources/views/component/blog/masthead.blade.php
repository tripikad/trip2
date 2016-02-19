<div class="c-blog-masthead {{ $modifiers or '' }}"
    @if (isset($image))
    style="background-image: url({{ $image }});"
    @endif
>

    <div class="c-blog-masthead__content">

    @if(isset($user))

        @if(isset($user['description']))

        <div class="c-blog-masthead__content-inner">

        @endif

        <div class="c-blog-masthead__user">

            <div class="c-blog-masthead__user-image">

                @if(isset($user['editor']))

                    @include('component.profile', [
                        'modifiers' => 'm-full m-status',
                        'image' => $user['image'],
                        'route' => $user['route'],
                        'letter' => [
                            'modifiers' => $user['color'].' m-small',
                            'text' => $user['letter']
                        ],
                        'status' => [
                            'modifiers' => $user['color'],
                            'position' => $user['status'],
                            'editor' => true
                        ]
                    ])
                @else

                    @include('component.profile', [
                        'modifiers' => 'm-full m-status',
                        'image' => $user['image'],
                        'route' => $user['route'],
                        'letter' => [
                            'modifiers' => $user['color'].' m-small',
                            'text' => $user['letter']
                        ],
                        'status' => [
                            'modifiers' => $user['color'],
                            'position' => $user['status'],
                        ]
                    ])

                @endif

            </div>

            <a href="{{ $user['route'] }}" class="c-blog-masthead__user-name">{{ $user['name'] }}</a>

        </div>

        @if(isset($user['description']))

            <p class="c-blog-masthead__description">{{ $user['description'] }}</p>

            <a href="#" class="c-blog-masthead__follow">
                @include('component.svg.sprite',[
                    'name' => 'icon-plus'
                ])
                Jälgi <span>(26)</span>
            </a>

        @endif

    @endif

    @if(isset($title))

        <h1 class="c-blog-masthead__title">{{ $title }}</h1>

    @endif

    @if(isset($date))

        <p class="c-blog-masthead__meta">{{ $date }}</p>

    @endif

    @if(isset($user['description']))

    </div>

    @endif

    </div>

</div>