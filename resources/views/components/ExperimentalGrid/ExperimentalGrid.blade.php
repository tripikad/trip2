@php

$items = collect($items) ?? collect();
$cols = $cols ?? 3;
$rows = round($items->count() / $cols, PHP_ROUND_HALF_DOWN);
$widths = $widths ?? 'repeat('. $cols .', 1fr)';
$heights = $heights ?? 'repeat('. $rows .', auto)';
$gap = isset($gap) ? 'calc('.$gap.' * 12px)' : '0';

@endphp

<div class="ExperimentalGrid {{ $isclasses }}" style="
        grid-template-columns: {{ $widths }};
        grid-template-rows: {{ $heights }};
        grid-gap: {{ $gap }}
    ">

    @foreach ($items as $item)

    <div class="ExperimentalGrid__item">

        {!! $item !!}

    </div>

    @endforeach

</div>