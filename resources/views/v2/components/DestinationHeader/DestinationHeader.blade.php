@php

$map = $map ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="DestinationMasthead {{ $isclasses }}">

    <div class="DestinationMasthead__map">

        {!! $map !!}
        
    </div>

    <div class="container">

        <div class="DestinationMasthead__navbar">

            {!! $navbar !!}
            
        </div>

        <div class="DestinationMasthead__name">

            {!! $name !!}

        </div>

        <div class="DestinationMasthead__meta">

            {!! $meta !!}

        </div>

    </div>
    
</div>
