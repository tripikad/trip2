@php

$title = $title ?? '';
$route = $route ?? '';

@endphp

@if ($route)

<a href="{{ $route }}">

@endif

<div class="StyleHeader {{ $isclasses }}">

  {!! $title !!}

</div>

@if ($route)

</a>

@endif