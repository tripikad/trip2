{{--

title: Destination

code: |

    @include('component.destination', [
        'title' => 'Here is title',
        'title_route' => '',
        'subtitle' => 'Here is subtitle',
        'subtitle_route' => '',
        'modifiers' => $modifiers
    ])

modifiers:

- m-red
- m-blue
- m-green
- m-orange
- m-yellow
- m-purple

--}}

<div class="c-destination {{ $modifiers or 'm-yellow' }}">

	<div class="c-destination__header">

        <h3 class="c-destination__title">

            @if(isset($title_route))

                <a href="{{ $title_route }}" class="c-destination__title-link">

            @endif

                @if(isset($title))

                    {{ $title }} &rsaquo;

                @else

                    &nbsp;

                @endif

            @if(isset($title_route))

                </a>

            @endif

        </h3>


        <div class="c-destination__subtitle">

            @if(isset($subtitle_route))

                <a href="{{ $subtitle_route }}" class="c-destination__subtitle-link">

            @endif

                @if(isset($subtitle))

                    {{ $subtitle }} &rsaquo;

                @else

                    &nbsp;

                @endif

            @if(isset($subtitle_route))

                </a>

            @endif

        </div>

	</div>
</div>
