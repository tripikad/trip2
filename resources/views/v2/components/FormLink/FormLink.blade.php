@php

$isclasses = $isclasses ?? '';
$title = $title ?? ''

@endphp

<input class="FormLink {{ $isclasses }}" type="submit" value="{{ $title }}">