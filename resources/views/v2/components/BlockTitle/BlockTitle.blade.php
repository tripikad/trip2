@php

$title = $title ?? '';
$route = $route ?? '';

@endphp

<div class="BlockTitle {{ $isclasses }}">

    <div>

        @if ($route)

        <a href="{{ $route }}">

        @endif

        <div class="BlockTitle__title">

            {{ $title }}

        </div>

        @if ($route)

        <a href="{{ $route }}">

        @endif

    </div>

    @if ($route)

    <div class="BlockTitle__link">
    
        {!! component('Link')->with('route', $route) !!}    

    </div>

    @endif

</div>
