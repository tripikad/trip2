@php

$background = $background ?? '';
$route = $route ?? '';
$title = $title ?? '';

@endphp

<div class="FlightCard {{ $isclasses }}" 
    style="background-image: linear-gradient(
      rgba(0, 0, 0, 0.3),
      rgba(0, 0, 0, 0.3)
    ), url({{ $background }});">

    <a href="{{ $route }}">

    <div class="FlightCard__title">

        {{ $title }}

    </div>

    </a>

</div>
