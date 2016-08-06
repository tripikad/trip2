@php

$route = $route ?? '';
$title = $title ?? '';

@endphp

<span class="MetaItem {{ $isclasses }}">

    @if ($route) <a href="{{ $route }}"> @endif

    <span class="MetaItem__title">

        {{ $title }}

    </span>

    @if ($route) </a> @endif

</span>
