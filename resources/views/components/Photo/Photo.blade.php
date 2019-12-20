@php

$photo = $photo ?? ''

@endphp

<div class="Photo {{ $isclasses }}" />

<img class="Photo__image" src="{{ $photo }}" />

</div>