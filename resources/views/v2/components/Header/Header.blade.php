@php

$map = $map ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="Header {{ $isclasses }}">

    <div class="Header__map">

    {!! $map !!}
    
    </div>

    <div class="container">

        <div class="Header__navbar">

            {!! $navbar !!}
            
        </div>

        <div class="Header__content">

            <div class="Header__title">

            {!! $title !!}

            </div>

            <div class="Header__meta">

            {!! $meta !!}

            </div>

        </div>

    </div>

</div>
