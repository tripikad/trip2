@php

$isclasses = $isclasses ?? '';
$title = $title ?? '';
$route = $route ?? '';
$external = $external ?? false;

@endphp

<div class="Title {{ $isclasses }}">

    @if ($route)

    <a href="{{ $route }}" @if($external) target="_blank" @endif>

        @endif

        <h2 class="Title__title">

            {!! $title !!}

        </h2>

        @if ($route)

    </a>

    @endif

</div>