@php

$route = $route ?? '';
$target = isset($external) ? '_blank' : '';
$icon = $icon ?? '';
$title = $title ?? '';

@endphp


<a href="{{ $route }}" target="{{ $target }}">

    <div class="Button {{ $isclasses }}">

        @if ($icon)

        <div class="Button__icon">

            {!! component('Icon')->is('white')->with('icon', $icon) !!}

        </div>
    
        @endif

        <div class="Button__title">

            {{ $title }}

        </div>

    </div>

</a>
