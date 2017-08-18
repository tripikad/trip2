@php
    $title = $title ?? '';
    $route = $route ?? '';
@endphp

@if($route)
    <a href="{{ $route }}">
@endif

        <div class="AuthTab {{ $isclasses }}">

            <div class="AuthTab__title">

                {{ $title }}

            </div>

        </div>
@if($route)
    </a>
@endif
