@php
$items = $items ?? [];

$cols = 'repeat(' . (collect($items)->count() - 1) . ', auto) 1fr';

$spacer = style_vars()->spacer;

$gap_map = ['sm' => 1, 'md' => 2, 'lg' => 3];

if (isset($gap) && is_string($gap) && $gap_map[$gap]) {
  $gap_string = 'calc('. $gap_map[$gap] .' * '. $spacer .')';
} 
else if (isset($gap) && !is_string($gap)) {
  $gap_string = 'calc('. $gap .' * '. $spacer .')';
} else {
  $gap_string = 'calc('. $gap_map['md'] .' * '. $spacer .')';
}
@endphp

<div class="ExperimentalRow {{ $isclasses }}" style="
        grid-template-columns: {{ $cols }};
        grid-gap: {{ $gap_string }};
    ">

    @foreach ($items as $item)

    <div class="ExperimentalRow__item">

        {!! $item !!}

    </div>

    @endforeach

</div>