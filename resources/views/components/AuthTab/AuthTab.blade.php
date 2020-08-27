@php
    $title = $title ?? '';
    $route = $route ?? '';
@endphp

<div class="AuthTab {{ $isclasses }}">

    @if($route)
        <a href="{{ $route }}">
    @endif

    <span class="AuthTab__title">

        {{ $title }}

    </span>

    @if($route)
        </a>
    @endif

</div>
