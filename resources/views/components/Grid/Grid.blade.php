@php

$items = $items ?? [];
$cols = $cols ?? 2;
$rows = round(collect($items)->count() / $cols, PHP_ROUND_HALF_DOWN);
$widths = $widths ?? 'repeat('. $cols .', 1fr)';
$heights = $heights ?? 'repeat('. $rows .', auto)';
$border = isset($debug) ? '1px dashed ' . styles('red') : 'none';
$gap_value = isset($gap) ? spacer($gap) : '0';

@endphp

<div class="Grid {{ $isclasses }}" style="
        grid-template-columns: {{ $widths }};
        grid-template-rows: {{ $heights }};
        grid-gap: {{ $gap_value }}
    ">

  @foreach ($items as $item)

  <div class="Grid__item" style="border: {{ $border }};">

    @foreach (items($item) as $collection_item)

    <div>

      {!! $collection_item !!}

    </div>

    @endforeach

  </div>

  @endforeach

</div>