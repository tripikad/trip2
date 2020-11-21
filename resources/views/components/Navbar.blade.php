<div class="Navbar Navbar--{{$mode}}">
    <div class="Navbar__logo">
        <a href="{{ route('frontpage.index') }}">
            <svg>
                <use xlink:href="{{$svg}}"></use>
            </svg>
        </a>
    </div>

    <div class="Navbar__right">
        <div class="Navbar__search">
            <navbar-search
                    isclasses="NavbarSearch--{{$mode}}">
            </navbar-search>
        </div>

        <div class="Navbar__desktop">
            <navbar-desktop
                    isclasses="NavbarDesktop--{{$mode}}"
                    :title="{{json_encode($title)}}"
                    :route="{{json_encode($route)}}"
                    :user="{{ $user ? json_encode($user) : 'null' }}"
                    :links='{{ json_encode($menuLinks) }}'
                    :sublinks='{{ json_encode($userLinks) }}'>
            </navbar-desktop>
        </div>

        <div class="Navbar__mobile">
            <navbar-mobile isclasses="NavbarMobile--{{$mode}}"
                           :title="{{json_encode($title)}}"
                           :route="{{json_encode($route)}}"
                           :user="{{ $user ? json_encode($user) : 'null' }}"
                           :links='{{ json_encode($menuLinks) }}'
                           :sublinks='{{ json_encode($userLinks) }}'>
            </navbar-mobile>
        </div>
    </div>
</div>
