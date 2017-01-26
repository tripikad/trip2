@php

$route = $route ?? '';
$user = $user ?? '';
$title = $title ?? '';
$meta = $meta ?? collect();

@endphp

<h3 class="FlightRow {{ $isclasses }}">

    <div class="FlightRow__left">

        {!! $icon !!}

    </div>

    <div class="FlightRow__right">

        <div>

            <a href="{{ $route }}">

            <div class="FlightRow__title">

                {{ $title }}

            </div>

            <div class="FlightRow__meta">

                {!! $meta !!}
            
            </div>

            </a>

        </div>

    </div>

</h3>