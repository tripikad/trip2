@php

$background = $background ?? '/photos/map.svg';

@endphp

<div
    class="MapBackground {{ $isclasses }}"
    style="background-image: url({{ $background }})"
>
</div>
