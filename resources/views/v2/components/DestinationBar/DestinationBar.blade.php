@php

$route = $route ?? '';
$title = $title ?? '';
$subtitle = $subtitle ?? '';

@endphp

<a href="{{ $route }}">

<div class="DestinationBar {{ $isclasses }}">


    <div class="DestinationBar__icon">

        {!! component('Icon')->with('icon', 'icon-pin')->with('size', 'xl') !!}

    </div>

    <div>
        
        <div class="DestinationBar__subtitle">

            {!! $subtitle !!}

        </div>

        <div class="DestinationBar__title">

            {{ $title }} ›

        </div>

    </div>

</div>

</a>