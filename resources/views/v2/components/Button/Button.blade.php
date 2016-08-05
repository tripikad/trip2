@php

$icon = $icon ?? '';
$route = $route ?? '';
$title = $title ?? '';

@endphp


<a href="{{ $route }}">

    <div class="Button {{ $isclasses }}">

        @if (!empty($icon))

        <div class="Button__icon">

        {!! component('Icon')->is('white')->with('icon', $icon) !!}

        </div>
    
        @endif

        <div class="Button__title">

            {{ $title }}

        </div>

    </div>

</a>
