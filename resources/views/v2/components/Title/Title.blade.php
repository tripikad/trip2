@php

$isclasses = $isclasses ?? '';
$title = $title ?? '';
$route = $route ?? '';

@endphp

<div class="Title {{ $isclasses }}">


    @if ($route)

    <a href="{{ $route }}">

    @endif

        <div class="Title__title">

        {{ $title }}

        </div>

    @if ($route)
    
    </a>
    
    @endif

</div>
