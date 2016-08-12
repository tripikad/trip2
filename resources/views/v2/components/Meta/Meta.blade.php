@php

$items = $items ?? collect();

@endphp

<div class="Meta {{ $isclasses }}">

    @foreach ($items as $item)

        {!! $item !!}

    @endforeach

</div>