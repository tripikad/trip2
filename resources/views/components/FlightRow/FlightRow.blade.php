@php

$route = $route ?? '';
$user = $user ?? '';
$title = $title ?? '';
$meta = $meta ?? collect();

@endphp

<div class="FlightRow {{ $isclasses }}">

    <div class="FlightRow__left">

        {!! $icon !!}

    </div>

    <div class="FlightRow__right">

        <div>

            <a href="{{ $route }}">

            <h3 class="FlightRow__title">

                {{ $title }}

            </h3>

            <div class="FlightRow__meta">

                {!! $meta !!}
            
            </div>

            </a>

        </div>

    </div>

</div>