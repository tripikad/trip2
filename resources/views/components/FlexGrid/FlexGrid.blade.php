@php

$items = $items ?? [];
$cols = $cols ?? 3;
$gapclass = isset($gap) ? 'Grid--gap'.$gap : '';
$widths = isset($widths) ? preg_split('/\s+/', preg_replace('/[^0-9\s]/','',$widths)) : array_fill(0, $cols, 1);

$spacer = style_vars('spacer');

$gap_map = ['sm' => 1, 'md' => 2, 'lg' => 3];

if (isset($gap) && is_string($gap) && $gap_map[$gap]) {
  $gap_string = 'calc('. $gap_map[$gap] .' * '. $spacer .')';
} 
else if (isset($gap) && !is_string($gap)) {
  $gap_string = 'calc('. $gap .' * '. $spacer .')';
} else {
  $gap_string = '';
}

@endphp

<div class="FlexGrid {{ $isclasses }}">

    @foreach (collect($items)->chunk($cols) as $row)

        <div class="FlexGrid__row" style="marginBottom: {{ $loop->last ? '' : $gap_string }}">

            @foreach ($row->values() as $colIndex => $item)

                <div class="FlexGrid__item" style="flex: {{ $widths[$colIndex] }}; marginRight: {{ $loop->last ? '' : $gap_string }}">

                    {!! $item !!}

                </div>
            
            @endforeach

        </div>

    @endforeach

</div>
