@php

$route = $route ?? '';
$title = $title ?? '';

@endphp

<div class="MetaItem {{ $isclasses }}">

    @if ($route) <a href="{{ $route }}"> @endif

    <div class="MetaItem__title">

        {{ $title }}

    </div>

    @if ($route) </a> @endif

</div>
