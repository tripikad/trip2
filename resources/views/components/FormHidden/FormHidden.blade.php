@php

$name = $name ?? '';
$value = $value ?? '';

@endphp

<input type="hidden" name="{{ $name }}" value="{{ $value }}">
