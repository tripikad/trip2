@php

$map = $map ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="Masthead {{ $isclasses }}">

    <div class="Masthead__map">

    {!! $map !!}
    
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
