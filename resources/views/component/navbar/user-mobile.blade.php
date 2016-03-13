<ul class="c-navbar-mobileuser {{ $modifiers or '' }}">

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