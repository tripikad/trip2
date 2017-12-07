@php

$items = collect($items) ?? collect();
$cols = $cols ?? 'repeat('.$items->count().', 1fr)';
$rows = $rows ?? 'repeat('.$items->count().', auto)';
$gap = isset($gap) ? 'calc('.$gap.' * 12px)' : '0';

@endphp

<div
    class="ExperimentalGrid {{ $isclasses }}"
    style="
        grid-template-columns: {{ $cols }};
        grid-template-rows: {{ $rows }};
        grid-gap: {{ $gap }}
    "
>
    
    @foreach ($items as $item)

        <div class="ExperimentalGrid__item">

            {!! $item !!}

        </div>

    @endforeach

</div>
