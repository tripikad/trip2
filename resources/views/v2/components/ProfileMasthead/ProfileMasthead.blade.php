@php

$map = $map ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="ProfileMasthead {{ $isclasses }}">

    <div class="ProfileMasthead__map">

        {!! $map !!}
        
    </div>

    <div class="ProfileMasthead__bottom">

    <div class="container">

        <div class="ProfileMasthead__header">

            {!! $header !!}
            
        </div>

        <div class="ProfileMasthead__profile">

            {!! $profile !!}

        </div>

        <div class="ProfileMasthead__name">

            {!! $name !!}

        </div>

        <div class="ProfileMasthead__meta">

            {!! $meta !!}

        </div>

    </div>

    </div>
    
</div>
