@php

$route = $route ?? '';
$target = isset($external) ? '_blank' : '';
$icon = $icon ?? '';
$title = $title ?? '';

@endphp


<a href="{{ $route }}" target="{{ $target }}">

    <div class="Btn {{ $isclasses }}">

        @if ($icon)

        <div class="Btn__icon">

            {!! component('Icon')->is('white')->with('icon', $icon) !!}

        </div>
    
        @endif

        <div class="Btn__title">

            {{ $title }}

        </div>

    </div>

</a>
