@php

$items = collect($items) ?? collect();
$widths = $widths ?? 'repeat('.$items->count().', 1fr)';
$heights = $heights ?? 'repeat('.$items->count().', auto)';
$gap = isset($gap) ? 'calc('.$gap.' * 12px)' : '0';

@endphp

<div
    class="ExperimentalGrid {{ $isclasses }}"
    style="
        grid-template-columns: {{ $widths }};
        grid-template-rows: {{ $heights }};
        grid-gap: {{ $gap }}
    "
>
    
    @foreach ($items as $item)

        <div class="ExperimentalGrid__item">

            {!! $item !!}

        </div>

    @endforeach

</div>
