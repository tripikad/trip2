@php

$background = $background ?? '';
$route = $route ?? '';
$title = $title ?? '';
$height = $height ?? 15;
$opacity = $opacity ?? 0.3
@endphp

<div class="ExperimentCard {{ $isclasses }}" 
    style="
        height: calc({{ $height}} * 12px);
        background-image: linear-gradient(
            rgba(0, 0, 0, {{ $opacity }}),
            rgba(0, 0, 0, {{ $opacity }})
            ),
            url({{ $background }});
    ">

    <a href="{{ $route }}">

    <div class="ExperimentCard__wrapper">

    <h3 class="ExperimentCard__title">

        {{ $title }}

    </h3>

    </div>

    </a>

</div>
