@php

$code = $code ?? '';
$language = $language ?? 'php';

@endphp

<div class="Code {{ $isclasses }}">{!! highlight($code, $language) !!}</div>
