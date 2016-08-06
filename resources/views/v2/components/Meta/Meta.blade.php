@php

$profile_name = $profile_name ?? '';
$profile_route = $profile_route ?? '';
$date = $date ?? '';
$date_route = $date_route ?? '';

@endphp

<span class="Meta {{ $isclasses }}">

    <a href="{{ $profile_route }}">

    <span class="Meta__profileName">

        {{ $profile_name }}

    </span>

    </a>

    @if ($date_route) <a href="{{ $date_route }}"> @endif

    <span class="Meta__date">

        {{ $date }}

    </span>

    @if ($date_route) </a> @endif

</span>
