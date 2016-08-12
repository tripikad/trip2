@php

$items = $items ?? collect();

@endphp

<div class="Meta {{ $isclasses }}">

    @foreach ($items as $item)

        <div class="Meta__item">

        {!! $item !!}

        </div>
        
    @endforeach

</div>