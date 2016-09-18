@php

$route = $route ?? '';
$title = $title ?? '';

@endphp

<div class="MetaLink {{ $isclasses }}">

    @if ($route) <a href="{{ $route }}"> @endif

    <div class="MetaLink__title">

        {{ $title }}

    </div>

    @if ($route) </a> @endif

</div>
