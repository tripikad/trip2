@php

$image = $image ?? ''

@endphp

<div class="Image {{ $isclasses }}" />

<img class="Image__image" src="{{ $image }}" />

</div>