{{--

title: Masthead

description: By default masthead has no background and the text is black, the m-alternative class is used together with background image. The front page uses m-search class to properly align the search box.

code: |

    @include('component.masthead', [
        'modifiers' => $modifiers,
        'image' => ''
    ])

modifiers:

- m-alternative
- m-search

--}}

<div class="c-masthead {{ $modifiers or '' }}"
    @if (isset($image))
    style="background-image: url({{ $image }});"
    @endif
>

    @yield('masthead.nav')

    <div class="c-masthead__body">

        <div class="c-masthead__logo">

            @if (isset($image))

                @include ('component.logo',[
                    'modifiers' => ''
                ])

            @else

                @include ('component.logo',[
                    'modifiers' => 'm-dark'
                ])

            @endif

        </div>

        <h1 class="c-masthead__title">@yield('title')</h1>

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