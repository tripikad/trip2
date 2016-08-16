@php

$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="Masthead {{ $isclasses }}">

    <div class="Masthead__map">

    <component is="Map"
            left="-100"
            bottom="-30"
            right="183"
    ></component>
    
    </div>

    <div class="container">

        <div class="Masthead__header">

            {!! $header !!}
            
        </div>

        <div class="Masthead__content">

            <div class="Masthead__title">

            {!! $title !!}

            </div>

            <div class="Masthead__meta">

            {!! $meta !!}

            </div>

        </div>

    </div>

</div>
