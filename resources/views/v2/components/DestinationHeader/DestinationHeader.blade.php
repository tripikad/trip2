@php

$map = $map ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';
$navbar = $navbar ?? '';
$background = $background ?? '';

@endphp

<div class="DestinationHeader {{ $isclasses }}">

    <div class="container">

        <div class="DestinationHeader__navbar">

            {!! $navbar !!}
            
        </div>

        <div class="DestinationHeader__name">

            {!! $name !!}

        </div>

        <div class="DestinationHeader__facts">

            {!! $facts !!}

        </div>

    </div>
    
    {!! $background !!}

</div>
