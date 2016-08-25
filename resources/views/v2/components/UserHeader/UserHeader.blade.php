@php

$map = $map ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="UserHeader {{ $isclasses }}">

    <div class="UserHeader__map">

        {!! $map !!}
        
    </div>

    <div class="UserHeader__bottom">

    <div class="container">

        <div class="UserHeader__navbar">

            {!! $navbar !!}
            
        </div>

        <div class="UserHeader__user">

            {!! $user !!}

        </div>

        <div class="UserHeader__name">

            {!! $name !!}

        </div>

        <div class="UserHeader__meta">

            {!! $meta !!}

        </div>

    </div>

    </div>
    
</div>
