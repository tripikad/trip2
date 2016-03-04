<ul class="c-navbar-mobileuser {{ $modifiers or '' }}">

    <li class="c-navbar-mobileuser__item m-image">
        <a href="{{ $profile['route'] }}" class="c-navbar-mobileuser__item-link">
            <span class="c-navbar-mobileuser__item-text">{{ str_limit($profile['title'], 15) }}</span>

            @if (isset($profile))

            <div class="c-navbar-mobileuser__item-image">

                @include('component.profile', [
                    'modifiers' => 'm-mini',
                    'image' => $profile['image'],
                    'letter' => $profile['letter'],
                ])
            </div>

            @endif
        </a>
    </li>

    @if (isset($children))

        @foreach($children as $child)

            <li class="c-navbar-mobileuser__item">

                <a href="{{ $child['route'] }}" class="c-navbar-mobileuser__item-link">
                    <span class="c-navbar-mobileuser__item-text">{{ $child['title'] }}</span>

                    @if (isset($child['badge']))

                        <span class="c-navbar-mobileuser__item-badge">

                        @include('component.badge', [
                            'modifiers' => $modifiers,
                            'count' => $child['badge']
                        ])

                        </span>

                    @endif
                </a>

            </li>

        @endforeach

    @endif

</ul>