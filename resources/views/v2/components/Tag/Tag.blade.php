@php

$title = $title ?? '';
$route = $route ?? '';

@endphp

@if ($route)

<a href="{{ $route }}">

@endif

<div class="Tag {{ $isclasses }}">

    <div class="Tag__title">

        {{ $title }}

    </div>

</div>

@if ($route)

</a>

@endif