@php

$search = $search ?? '';
$logo = $logo ?? '';
$navbar = $navbar?? '';
$navbar_mobile = $navbar_mobile ?? '';

@endphp

<div class="Header {{ $isclasses }}">
    
    <div class="Header__left">

        <div class="Header__search">

            {!! $search !!}

        </div>

        <div class="Header__logo">

            {!! $logo !!}

        </div>

    </div>

    <div class="Header__right">

        <div class="Header__navbar">

            {!! $navbar !!}

        </div>

        <div class="Header__navbarMobile">

            {!! $navbar_mobile !!}

        </div>

    </div>

</div>