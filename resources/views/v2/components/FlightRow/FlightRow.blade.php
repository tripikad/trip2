@php

$route = $route ?? '';
$profile = $profile ?? '';
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

            <div class="FlightRow__title">

                {{ $title }}

            </div>

            <div class="FlightRow__meta">

                {!! $meta !!}
            
            </div>

            </a>

        </div>

    </div>

</div>