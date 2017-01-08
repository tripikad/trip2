@php

$title = $title ?? '';
$route = $route ?? '';
$link = $link ?? '';

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

    @if ($link)

    <div class="BlockTitle__link">
    
        {!! $link !!}    

    </div>

    @endif

</div>
