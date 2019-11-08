@php

$key = $key ?? '';
$value = $value ?? '';

@endphp

<div class="StyleFont {{ $isclasses }}">

    <div class="StyleFont__font">
        <div class="{{ $key }}">

        Because of its antiquity and importance, the city center retains many buildings, plazas, streets and churches from colonial times, and even some pre-Columbian structures.
        </div>
    </div>

    <div class="StyleFont__code">

        <div class="StyleFont__key">font: <span class="hljs-string">${!! $key !!}</span></div>
        
        <div class="StyleFont__value">{!! $value !!}</div>

    </div>

</div>