@php

$route = $route ?? route('frontpage.index');
$search = $search ?? '';
$logo = $logo ?? '';
$sitename = $sitename ?? config('site.name');
$navbar_desktop = $navbar_desktop ?? '';
$navbar_mobile = $navbar_mobile ?? '';

@endphp

<div class="Navbar {{ $isclasses }}">
    
    <div class="Navbar__left">

        <a href="{{ $route }}">

            <h1 class="Navbar__logo">

                {!! $logo !!}

                <div class="Navbar__sitename">{{ $sitename }}</div>

            </h1>

        </a>
        
    </div>

    <div class="Navbar__right">

        <div class="Navbar__search">

            {!! $search !!}

        </div>
        
        <div class="Navbar__desktop">

            {!! $navbar_desktop !!}

        </div>

        <div class="Navbar__mobile">

            {!! $navbar_mobile !!}

        </div>

    </div>

</div>