@php

$map = $map ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';
$background = $background ?? '';

@endphp

<div class="UserHeader {{ $isclasses }}">

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

        <div class="UserHeader__stats">

            {!! $stats !!}

        </div>

    </div>

    {!! $background !!}

</div>
