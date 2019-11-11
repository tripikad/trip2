@php

$items = $items ?? [];
$cols = 'repeat(' . (collect($items)->count() - 1) . ', auto) 1fr';
$gap = isset($gap) ? 'calc('.$gap.' * 12px)' : '12px';

@endphp

<div class="ExperimentalRow {{ $isclasses }}" style="
        grid-template-columns: {{ $cols }};
        grid-gap: {{ $gap }};
    ">

    @foreach ($items as $item)

    <div class="ExperimentalRow__item">

        {!! $item !!}

    </div>

    @endforeach

</div>