@php

$image = $image ?? ''

@endphp

<div class="Photo {{ $isclasses }}" />

<img class="Photo__image" src="{{ $image }}" />

</div>