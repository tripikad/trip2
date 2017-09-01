@php
    $url = $url ?? '#';
    $user = $user ?? '';
    $date = $date ?? '';
@endphp
{{ $slot }} - {{ $user }} - {{ $date }}: {{$url}}
