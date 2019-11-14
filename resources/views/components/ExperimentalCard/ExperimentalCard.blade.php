@php

$background = $background ?? '';
$route = $route ?? '';
$title = $title ?? '';
$height = $height ?? 12;
$opacity = $opacity ?? 0.25;

@endphp

<div class="ExperimentalCard {{ $isclasses }}" 
    style="
        min-height: calc({{ $height}} * {{ style_vars()->spacer }});
        background-image: linear-gradient(
            rgba(0, 0, 0, {{ $opacity }}),
            rgba(0, 0, 0, {{ $opacity }})
            ),
            url({{ $background }});
    ">

    <a href="{{ $route }}">

        <div class="ExperimentalCard__wrapper">

            <h3 class="ExperimentalCard__title">

                {{ $title }}

            </h3>

        </div>

    </a>

</div>
