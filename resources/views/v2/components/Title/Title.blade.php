@php

$isclasses = $isclasses ?? '';
$title = $title ?? '';
$route = $route ?? '';

@endphp

<h2 class="Title {{ $isclasses }}">

    @if ($route)

    <a href="{{ $route }}">

    @endif

        <h2 class="Title__title">

        {{ $title }}

        </h2>

    @if ($route)
    
    </a>
    
    @endif

</h2>
