@php

$key = $key ?? '';
$value = $value ?? '';

@endphp

<div class="StyleFont {{ $isclasses }}">

    <div class="StyleFont__font">
        <div class="{{ $key }}">

After the absence of twenty-six years, Marco Polo and his father Nicolo and his uncle Maffeo returned from the spectacular court of Kublai Khan to their old home in Venice. 

        </div>
    </div>

    <div class="StyleFont__code">

        <div class="StyleFont__key">font: <span class="hljs-string">${!! $key !!}</span></div>
        
        <div class="StyleFont__value">{!!  highlight($value,'js') !!}</div>

    </div>

</div>