<div class="c-forum-post">

    @if (isset($profile))

        <div class="c-forum-post__profile">

            @include('component.profile', [
                'modifiers' => $profile['modifiers'],
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

        {!! $text !!}

    </div>

</div>