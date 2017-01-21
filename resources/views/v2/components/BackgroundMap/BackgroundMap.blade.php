@php

$image = $image ?? '/photos/map.svg';

@endphp

<div class="BackgroundMap {{ $isclasses }}">
    <div class="BackgroundMap__image">
        <img src="{{ $image }}" />
    </div>
</div>
