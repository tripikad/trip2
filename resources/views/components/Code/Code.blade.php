@php

$code = $code ?? '';
$route = $route ?? '';

@endphp


@if($route)
<a href="{{ $route }}">
@endif

<div class="Code {{ $isclasses }}">{{ $code }}</div>

@if($route)
</a>
@endif