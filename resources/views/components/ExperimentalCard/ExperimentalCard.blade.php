@php

$background = $background ?? '';
$route = $route ?? '';
$title = $title ?? '';
$height = $height ?? 12;
$opacity = $opacity ?? 0.25;
$darkened = $darkened ?? false;

@endphp

<div class="ExperimentalCard {{ $isclasses }}" 
    style="
        min-height: calc({{ $height}} * {{ styleVars()->spacer }});
        @if ($darkened)
        background-image: linear-gradient(
            rgba(0, 0, 0, {{ $opacity }}),
            rgba(0, 0, 0, {{ $opacity }})
            ),
            url({{ $background }});
        @else
            background-image: url({{ $background }});
        @endif
    ">

    <a href="{{ $route }}">

        <div class="ExperimentalCard__wrapper">

            <h3 class="ExperimentalCard__title">

                {{ $title }}

            </h3>

        </div>

    </a>

</div>
