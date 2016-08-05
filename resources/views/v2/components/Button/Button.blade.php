@php

$icon = $icon ?? false;
$route = $route ?? false;
$title = $title ?? false;

@endphp


<a href="{{ $route }}">

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
