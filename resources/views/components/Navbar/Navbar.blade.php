@php

$route = $route ?? route('frontpage.index');
$search = $search ?? '';
$logo = $logo ?? '';
$sitename = $sitename ?? config('site.name');
$navbar_desktop = $navbar_desktop ?? '';
$navbar_mobile = $navbar_mobile ?? '';

@endphp

<div class="Navbar {{ $isclasses }}">
    
    <div class="Navbar__logo">

        <a href="{{ $route }}">

            {!! $logo !!}

            <span class="Navbar__sitename">{{ $sitename }}</span>

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