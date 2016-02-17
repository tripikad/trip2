<div class="c-auth-masthead">

    <div class="c-auth-masthead__body">

        <div class="c-auth-masthead__logo">

            <a href="/" class="c-auth-masthead__logo-link">

                @include ('component.logo',[
                    'modifiers' => 'm-dark'
                ])
            </a>
        </div>

        @if (isset($title))

        <h1 class="c-auth-masthead__title">{{ $title }}</h1>

        @else

        <h1 class="c-auth-masthead__title">@yield('title')</h1>

        @endif

        @if (isset($subtitle))

        <h2 class="c-auth-masthead__subtitle">{!! $subtitle !!}</h2>

        @endif

    </div>
</div>