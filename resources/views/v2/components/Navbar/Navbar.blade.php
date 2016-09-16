@php

$search = $search ?? '';
$logo = $logo ?? '';
$navbar_desktop = $navbar_desktop ?? '';
$navbar_mobile = $navbar_mobile ?? '';

@endphp

<div class="Navbar {{ $isclasses }}">
    
    <div class="Navbar__left">

        <div class="Navbar__logo">

            {!! $logo !!}

        </div>
        
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