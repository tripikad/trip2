@php

$map = $map ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="UserMasthead {{ $isclasses }}">

    <div class="UserMasthead__map">

        {!! $map !!}
        
    </div>

    <div class="UserMasthead__bottom">

    <div class="container">

        <div class="UserMasthead__header">

            {!! $header !!}
            
        </div>

        <div class="UserMasthead__user">

            {!! $user !!}

        </div>

        <div class="UserMasthead__name">

            {!! $name !!}

        </div>

        <div class="UserMasthead__meta">

            {!! $meta !!}

        </div>

    </div>

    </div>
    
</div>
