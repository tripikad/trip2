@php

$title = $title ?? '';
$route = $route ?? '';

@endphp

<h2 class="Title {{ $isclasses }}">


    @if ($route)

    <a href="{{ $route }}">

    @endif

        <div class="Title__title">

        {{ $title }}

        </div>

    @if ($route)
    
    </a>
    
    @endif

</h2>
