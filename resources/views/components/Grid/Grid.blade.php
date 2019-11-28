@php

$items = $items ?? [];
$cols = $cols ?? 3;
$rows = round(collect($items)->count() / $cols, PHP_ROUND_HALF_DOWN);
$widths = $widths ?? 'repeat('. $cols .', 1fr)';
$heights = $heights ?? 'repeat('. $rows .', auto)';

$spacer = style_vars()->spacer;

$gap_map = ['sm' => 1, 'md' => 2, 'lg' => 3];

if (isset($gap) && is_string($gap) && $gap_map[$gap]) {
  $gap_string = 'calc('. $gap_map[$gap] .' * '. $spacer .')';
} 
else if (isset($gap) && !is_string($gap)) {
  $gap_string = 'calc('. $gap .' * '. $spacer .')';
} else {
  $gap_string = 'calc('. $gap_map['sm'] .' * '. $spacer .')';
}

@endphp

<div class="Grid {{ $isclasses }}" style="
        grid-template-columns: {{ $widths }};
        grid-template-rows: {{ $heights }};
        grid-gap: {{ $gap_string }}
    ">

    @foreach ($items as $item)

    <div class="Grid__item">

        {!! $item !!}

    </div>

    @endforeach

</div>