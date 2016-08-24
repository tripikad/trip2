@php

$map = $map ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="ProfileMasthead {{ $isclasses }}">

    <div class="ProfileMasthead__top">

    <div class="container">

        <div class="ProfileMasthead__header">

            {!! $header !!}
            
        </div>

    </div>

    </div>

    <div class="ProfileMasthead__bottom">

    <div class="container">

        <div class="ProfileMasthead__profile">

            {!! $profile !!}

        </div>

        <div class="ProfileMasthead__name">

            {!! $name !!}

        </div>

    </div>

    </div>
    
</div>
