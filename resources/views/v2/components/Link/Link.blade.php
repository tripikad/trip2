@php

$route = $route ?? '';
$title = $title ?? '';

@endphp

<div class="Link {{ $isclasses }}">

    @if ($route) <a href="{{ $route }}"> @endif

    <div class="Link__title">

        {{ $title }}

    </div>

    @if ($route) </a> @endif

</div>
