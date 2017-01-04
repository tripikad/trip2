@php

$title = $title ?? '';
$route = $route ?? '';

@endphp

<div class="Tag {{ $isclasses }}">

    @if ($route)

    <a href="{{ $route }}">

    @endif

        <div class="Tag__title">

            {{ $title }}

        </div>

    @if ($route)

    </a>

    @endif

</div>