@php

$route = $route ?? '';
$title = $title ?? '';

@endphp

<div class="LinkMeta {{ $isclasses }}">

    @if ($route) <a href="{{ $route }}"> @endif

    <div class="LinkMeta__title">

        {{ $title }}

    </div>

    @if ($route) </a> @endif

</div>
