

<div
    class="c-masthead"
    style="background-image: url({{
        isset($__env->getSections()['masthead.image'])
        ? $__env->getSections()['masthead.image']
        : \App\Image::getRandom()
    }});"
>

    @yield('masthead.nav')

    <div class="c-masthead__body {{ $modifiers or '' }}">

        <div class="c-masthead__logo {{ $logo_modifier or '' }}"><div class="c-logo {{ $logo_modifier or '' }}"></div></div>
        <h1 class="c-masthead__title">@yield('title')</h1>

        @if (isset($subtitle))

        <h2 class="c-masthead__subtitle"><a href="{{ $subtitle_route }}" class="c-masthead__subtitle-link">{{ $subtitle }} &rsaquo;</a></h2>

        @endif

        @yield('masthead.search')
    </div>
</div>
