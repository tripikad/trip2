@php

$route = $route ?? '';
$title = $title ?? '';
$subtitle = $subtitle ?? '';

@endphp

<div class="DestinationBar {{ $isclasses }}">

    <div class="DestinationBar__wrapper">
        
        <div class="DestinationBar__icon">

            {!! component('Icon')->with('icon', 'icon-pin')->with('size', 'xl') !!}

        </div>

        <div>
            
            <div class="DestinationBar__subtitle">

                {!! $subtitle  !!}

            </div>

            <a href="{{ $route }}">

                <div class="DestinationBar__title">

                    {{ $title }} ›

                </div>

            </a>

        </div>

    </div>

</div>
