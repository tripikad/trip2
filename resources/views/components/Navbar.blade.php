<div {{ $attributes->merge(['class' => 'Navbar']) }}>
    <div class="Navbar__logo">
        <a href="{{ route('frontpage.index') }}">
            <svg>
                <use xlink:href="{{$logo}}"></use>
            </svg>
        </a>
    </div>

    <div class="Navbar__right">
        <div class="Navbar__search">
            <navbar-search isclasses="NavbarSearch--{{$type}}" />
        </div>

        <div class="Navbar__desktop">
            <navbar-desktop
                    isclasses="NavbarDesktop--{{$type}}"
                    :title="{{json_encode($title)}}"
                    :route="{{json_encode($route)}}"
                    :user="{{ $user ? json_encode($user) : 'null' }}"
                    :links='{{ json_encode($menuLinks) }}'
                    :sublinks='{{ json_encode($userLinks) }}'/>
        </div>

        <div class="Navbar__mobile">
            <navbar-mobile isclasses="NavbarMobile--{{$type}}"
                           :title="{{json_encode($title)}}"
                           :route="{{json_encode($route)}}"
                           :user="{{ $user ? json_encode($user) : 'null' }}"
                           :links='{{ json_encode($menuLinks) }}'
                           :sublinks='{{ json_encode($userLinks) }}' />
        </div>
    </div>
</div>