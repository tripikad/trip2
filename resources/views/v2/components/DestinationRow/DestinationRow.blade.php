@php

$name = $name ?? '';
$route = $route ?? '';

@endphp

<div class="DestinationRow {{ $isclasses }}">

    <a href="{{ $route }}">

        <div class="DestinationRow__name">

        {{ $name }}

        </div>

    </a>

</div>
