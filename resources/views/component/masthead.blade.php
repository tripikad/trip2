{{--

title: Masthead

description: By default masthead has no background and the text is black, the m-alternative class is used together with background image. The front page uses m-search class to properly align the search box. User profile page uses m-profile to hide logo and title.

code: |

    @include('component.masthead', [
        'modifiers' => $modifiers,
        'image' => ''
    ])

modifiers:

- m-alternative
- m-search
- m-profile

--}}

<div class="c-masthead {{ $modifiers or '' }}"
    @if (isset($image))
    style="background-image: url({{ $image }});"
    @endif
>

    @if (isset($map) && $map === true)
        <div class="c-masthead__map">
            <div class="c-masthead__map-map">
                @include('component.svg.standalone', [
                    'name' => 'map'
                ])
            </div>
        </div>
    @endif

    @yield('masthead.nav')

    <div class="c-masthead__body">

        <div class="c-masthead__logo">

            <a href="/" class="c-masthead__logo-link">

            @if (isset($image) && isset($modifiers))

                @include ('component.logo',[
                    'modifiers' => ''
                ])

            @else

                @include ('component.logo',[
                    'modifiers' => 'm-dark'
                ])

            @endif

            </a>

        </div>

        @if (isset($title))

        <h1 class="c-masthead__title">
            @if (isset($route) && $route != '')
                <a href="{{ $route }}">
            @endif

            {{ $title }}

            @if (isset($route) && $route != '')
                </a>
            @endif
        </h1>

        @else

        <h1 class="c-masthead__title">
            @if (isset($route) && $route != '')
                <a href="{{ $route }}">
            @endif

            @yield('title')

            @if (isset($route) && $route != '')
                </a>
            @endif
        </h1>

        @endif

        @if (isset($subtitle))

        <h2 class="c-masthead__subtitle">

            @if (isset($subtitle_route))
            <a href="{{ $subtitle_route }}" class="c-masthead__subtitle-link">
            @endif

            {{ $subtitle }}

            @if (isset($subtitle_route))
            &rsaquo;</a>
            @endif

        </h2>

        @endif

        @if (isset($actions))
            <div class="c-masthead__actions">{!! $actions !!}</div>
        @endif

        @yield('masthead.search')

    </div>

    <div class="c-masthead__bottom">

        @yield('masthead.bottom')

    </div>

</div>

@yield('header1.left')
@yield('header1.top')
@yield('header1.bottom')
@yield('header1.right')

@yield('header2.content')
@yield('header3.content')